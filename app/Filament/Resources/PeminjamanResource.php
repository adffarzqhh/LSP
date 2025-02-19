<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Filament\Resources\PeminjamanResource\RelationManagers;
use App\Models\Peminjaman;
use App\Models\Gudang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('nama_peminjam')
                    ->label('Nama Peminjam')
                    ->placeholder('Masukkan Nama Anda')
                    ->required(),

                    Forms\Components\Select::make('gudang_id')
                    ->label('Kategori')
                    ->options(Gudang::all()->pluck('kategori_barang', 'id'))
                    ->placeholder('Pilih Kategori Barang')
                    ->required(),

                    Forms\Components\TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->placeholder('Masukkan Nama Barang')
                    ->required(),

                    Forms\Components\TextInput::make('stok')
                    ->label('Banyak Barang')
                    ->numeric()
                    ->required(),

                    Forms\Components\Select::make('status')
                    ->label('Status Barang')
                    ->options([
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Selesai',
                        'tersedia' => 'Tersedia',
                    ])
                    ->default('dipinjam')
                    ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_peminjam')->label('Nama Peminjam')->searchable(),
                Tables\Columns\TextColumn::make('nama_barang')->label('Nama Barang'),
                Tables\Columns\TextColumn::make('stok')->label('Banyak Barang Dipinjam'),
                Tables\Columns\TextColumn::make('status')->label('Status Barang'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPeminjamen::route('/'),
            'create' => Pages\CreatePeminjaman::route('/create'),
            'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }
}
