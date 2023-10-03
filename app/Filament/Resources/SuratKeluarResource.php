<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratKeluarResource\Pages;
use App\Filament\Resources\SuratKeluarResource\RelationManagers;
use App\Models\SuratKeluar;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class SuratKeluarResource extends Resource
{
    protected static ?string $model = SuratKeluar::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $pluralLabel = 'Surat Keluar';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Placeholder::make('Dibuat')
                        ->content(fn (SuratKeluar $record): string => $record->created_at->toFormattedDateString()),
                    Placeholder::make('Diubah')
                        ->content(fn (SuratKeluar $record): string => $record->updated_at->toFormattedDateString()),
                ])
                    ->columns(2)
                    ->visibleOn('edit'),
                TextInput::make('nomor')
                    ->required()
                    ->unique(),
                DatePicker::make('tgl')
                    ->label('Tanggal')
                    ->required(),
                TextInput::make('tujuan')
                    ->required(),
                Textarea::make('perihal')
                    ->rows(3)
                    ->required(),
                FileUpload::make('file')
                    ->acceptedFileTypes(['application/pdf'])
                    ->downloadable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor')
                    ->searchable(),
                TextColumn::make('tgl')
                    ->label('Tanggal'),
                TextColumn::make('tujuan')
                    ->searchable(),
                TextColumn::make('perihal')
                    ->searchable(),
            ])
            ->filters([
                Filter::make('tanggal')
                    ->form([
                        DatePicker::make('tanggal')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tgl', $date),
                            );
                    })
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Action::make('file')
                    ->icon('heroicon-o-document')
                    ->color('success')
                    ->url(fn (SuratKeluar $record): string => '/storage/'.$record->file)
                    ->openUrlInNewTab()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                ]),
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
            'index' => Pages\ListSuratKeluars::route('/'),
            'create' => Pages\CreateSuratKeluar::route('/create'),
            'edit' => Pages\EditSuratKeluar::route('/{record}/edit'),
        ];
    }    
}
