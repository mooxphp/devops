<?php

namespace Moox\ForgeServer\Resources;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Moox\ForgeServer\Jobs\DeployProjectJob;
use Moox\ForgeServer\Models\ForgeProject;
use Moox\ForgeServer\Resources\ForgeProjectResource\Pages\ListPage;
use Moox\ForgeServer\Resources\ForgeProjectResource\Widgets\ForgeProjectWidgets;

class ForgeProjectResource extends Resource
{
    protected static ?string $model = ForgeProject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->maxLength(255)
                    ->required(),
                TextInput::make('url')
                    ->maxLength(255)
                    ->required(),
                TextInput::make('server_id')
                    ->maxLength(255)
                    ->required(),
                TextInput::make('site_id')
                    ->maxLength(255)
                    ->required(),
                TextInput::make('behind')
                    ->maxLength(255),
                DateTimePicker::make('last_deployment'),
                TextInput::make('last_commit')
                    ->maxLength(255),
                TextInput::make('commit_message')
                    ->maxLength(255),
                TextInput::make('commit_author')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('3s')
            ->columns([
                TextColumn::make('name')
                    ->label(__('forge-servers::translations.name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('server.name')
                    ->label(__('forge-servers::translations.server'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('site_id')
                    ->label(__('forge-servers::translations.site_id'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('commits_behind')
                    ->label(__('forge-servers::translations.commits_behind'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('last_deployment')
                    ->label(__('forge-servers::translations.last_deployment'))
                    ->sortable()
                    ->since()
                    ->searchable(),
                TextColumn::make('deployment_status')
                    ->label(__('forge-servers::translations.deployment_status'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('last_commit_message')
                    ->label(__('forge-servers::translations.last_commit_message'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('last_commit_author')
                    ->label(__('forge-servers::translations.last_commit_author'))
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort('name', 'desc')
            ->actions([
                Action::make('deploy')
                    ->label('Deploy')
                    ->action(function ($record) {
                        DeployProjectJob::dispatch($record, auth()->user());
                        Notification::make()
                            ->title('Deploying project '.$record->name)
                            ->success()
                            ->send()
                            ->broadcast(auth()->user());
                    }),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
                BulkAction::make('deploy')
                    ->requiresConfirmation()
                    ->action(
                        fn (Collection $records) => $records->each(
                            fn ($record) => DeployProjectJob::dispatch($record, auth()->user()))),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPage::route('/'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            //ForgeProjectWidgets::class,
        ];
    }

    public static function getModelLabel(): string
    {
        return __('forge-servers::translations.project');
    }

    public static function getPluralModelLabel(): string
    {
        return __('forge-servers::translations.projects');
    }

    public static function getNavigationLabel(): string
    {
        return __('forge-servers::translations.forge_projects');
    }

    public static function getBreadcrumb(): string
    {
        return __('forge-servers::translations.projects');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getModel()::count());
    }

    public static function getNavigationGroup(): ?string
    {
        return __('forge-servers::translations.navigation_group');
    }

    public static function getNavigationSort(): ?int
    {
        return config('forge-servers.navigation_sort');
    }
}
