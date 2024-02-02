<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Role;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin'
        ]);

        Role::create([
            'name' => 'bank'
        ]);

        Role::create([
            'name' => 'kantin'
        ]);

        Role::create([
            'name' => 'siswa'
        ]);

        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('admin'), 
            'role_id' => 'admin',
        ]);

        User::create([
            'name' => 'bank',
            'username' => 'bank',
            'password' => Hash::make('bank'), 
            'role_id' => 'bank',
        ]);
        User::create([
            'name' => 'kantin',
            'username' => 'kantin',
            'password' => Hash::make('kantin'),
            'role_id' => 'kantin',
        ]);
        User::create([
            'name' => 'siswa',
            'username' => 'siswa',
            'password' => Hash::make('siswa'),
            'role_id' => 'siswa',
        ]);
        Student::create([
            'user_id' => 3,
            'nis' => 12332,
            'classroom' => 'XII RPL'
        ]);

        Category::create([
            'name' => 'Minuman'
        ]);
        Category::create([
            'name' => 'Makanan'
        ]);
        Category::create([
            'name' => 'Snack'
        ]);

        Product::create([
            'name' => 'Es Kelapa',
            'price' => 5000,
            'stock' => 50,
            'photo' =>'https://tse4.mm.bing.net/th?id=OIP.QF-6sTNcKxJ7cIVkbA8v8wHaHE&pid=Api&P=0&h=220',
            'desc' => 'segerrr bangett',
            'stand' => 1,
            'category_id' => 1,
        ]);
        Product::create([
            'name' => 'Nasi Goreng',
            'price' => 15000,
            'stock' => 50,
            'photo' =>'https://www.kitchensanctuary.com/wp-content/uploads/2020/07/Nasi-Goreng-square-FS-57.jpg',
            'desc' => 'enakkkkk',
            'stand' => 2,
            'category_id' => 2,
        ]);
        Product::create([
            'name' => 'Lays',
            'price' => 8000,
            'stock' => 50,
            'photo' =>'https://tse1.mm.bing.net/th?id=OIP.3HLtHN68AQmZEZ8HrRagnAHaHa&pid=Api&P=0&h=220',
            'desc' => 'gurihh',
            'stand' => 3,
            'category_id' => 3,
        ]);

        Wallet::create([
            'user_id' => 3,
            'credit' => 100000,
            'debit' => null,
            'description' => 'pembukaan tabungan'
        ]);
        Wallet::create([
            'user_id' => 3,
            'credit' => null,
            'debit' => 15000,
            'description' => 'peembelian produk'
        ]);
        Wallet::create([
            'user_id' => 3,
            'credit' => null,
            'debit' => 15000,
            'description' => 'peembelian produk'
        ]);
        Transaction::create([
            'user_id' => 3,
            'product_id' => 1,
            'status' => 'dikeranjang',
            'order_code' => 'INV_12345',
            'price' => 5000,
            'quantity' => 1
        ]);

        Transaction::create([
            'user_id' => 3,
            'product_id' => 2,
            'status' => 'dikeranjang',
            'order_code' => 'INV_12345',
            'price' => 5000,
            'quantity' => 1
        ]);
        Transaction::create([
            'user_id' => 3,
            'product_id' => 3,
            'status' => 'dikeranjang',
            'order_code' => 'INV_12345',
            'price' => 5000,
            'quantity' => 1
        ]);

        
        $total_debit = 0;
        
        $transactions = Transaction::where('order_code'==
        'INV_12345');
        foreach($transactions as $transaction)
        {
            $total_price = $transaction->price * $transaction->quantity;

            $total_debit += $total_price;
        }
        Wallet::create([
            'user_id' => 4,
            'debit' => $total_debit,
            'description' => 'peembelian produk'
        ]);
        foreach($transactions as $transaction)
        {
            Transaction::find($transaction->id)->update([
                'status' => 'dibayar'
            ]);
        }
        foreach($transactions as $transaction)
        {
            Transaction::find($transaction->id)->update([
                'status' => 'diambil'
            ]);
        }
    }
}