<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DisposisiResource\Pages;
use App\Filament\Resources\DisposisiResource\RelationManagers;
use App\Models\Disposisi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DisposisiResource extends Resource
{
    protected static ?string $model = Disposisi::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Split::make([
                    Section::make()
                        ->schema([
                            TextEntry::make('surat_masuk.tanggal')
                                ->label('Tanggal'),
                            TextEntry::make('surat_masuk.nomor')
                                ->label('Nomor Surat'),
                            TextEntry::make('surat_masuk.asal')
                                ->label('Asal'),
                        ])->columnSpanFull(),
                    Section::make()
                        ->schema([
                            TextEntry::make('surat_masuk.diterima')
                                ->label('Diterima'),
                            TextEntry::make('surat_masuk.sifat')
                                ->label('Sifat'),
                            TextEntry::make('bagian.nama'),
                        ]),
                ])
                    ->columnSpanFull()
                    ->from('md'),
                Section::make()
                    ->schema([
                        TextEntry::make('surat_masuk.perihal')
                            ->label('Perihal')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('surat_masuk.nomor'),
                TextColumn::make('bagian.nama'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDisposisis::route('/'),
            'view' => Pages\ViewDisposisi::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }
}
