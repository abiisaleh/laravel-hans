<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratMasukResource\Pages;
use App\Filament\Resources\SuratMasukResource\RelationManagers;
use App\Models\SuratMasuk;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportQueryString\BaseUrl;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class SuratMasukResource extends Resource
{
    protected static ?string $model = SuratMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $pluralLabel = 'Surat Masuk';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Placeholder::make('Dibuat')
                        ->content(fn (SuratMasuk $record): string => $record->created_at->toFormattedDateString()),
                    Placeholder::make('Diubah')
                        ->content(fn (SuratMasuk $record): string => $record->updated_at->toFormattedDateString()),
                ])
                    ->columns(2)
                    ->visibleOn('edit'),
                TextInput::make('nomor')
                    ->required(),
                DatePicker::make('tgl')
                    ->label('Tanggal')
                    ->required(),
                DatePicker::make('tgl_terima')
                    ->label('Tanggal diterima')
                    ->required(),
                TextInput::make('asal')
                    ->required(),
                TextInput::make('sifat')
                    ->required(),
                Select::make('disposisi')
                    ->options([
                        'Kepala Bagian Pemerintahan Umum' => 'Kepala Bagian Pemerintahan Umum',
                        'Kepala Bagian Pemerintahan Kampung dan Kelurahan' => 'Kepala Bagian Pemerintahan Kampung dan Kelurahan',
                        'Kepala Bagian Pengembangan Wilayah' => 'Kepala Bagian Pengembangan Wilayah',
                        'Kepala Bagian Pemerintahan Pengkajian dan Pengembangan Otonomi Khusus' => 'Kepala Bagian Pemerintahan Pengkajian dan Pengembangan Otonomi Khusus',
                    ]),
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
                TextColumn::make('tgl_terima')
                    ->label('Diterima'),
                TextColumn::make('asal')
                    ->limit(25)
                    ->searchable(),
                TextColumn::make('sifat')
                    ->searchable(),
                TextColumn::make('disposisi')
                    ->limit(25)
                    ->tooltip(fn (SuratMasuk $record): string => $record->disposisi ?? '')
                    ->searchable(),
                TextColumn::make('perihal')
                    ->limit(25)
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
                    ->url(fn (SuratMasuk $record): string => '/storage/' . $record->file)
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
            'index' => Pages\ListSuratMasuks::route('/'),
            'create' => Pages\CreateSuratMasuk::route('/create'),
            'edit' => Pages\EditSuratMasuk::route('/{record}/edit'),
        ];
    }
}
