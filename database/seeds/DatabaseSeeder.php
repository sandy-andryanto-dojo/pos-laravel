<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserConfirm;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Type;
use App\Models\Transaction;
use App\Models\TransactionDetail;


class DatabaseSeeder extends Seeder {

    public function run() {
        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");
        }

        $countPermission = Permission::count();
        $countRole = Role::count();

        if($countPermission == 0 && $countRole == 0){

              // Seed the default permissions
            $permissions = Permission::defaultPermissions();

            foreach ($permissions as $perms) {
                Permission::firstOrCreate(['name' => $perms]);
            }

            $this->command->info('Default Permissions added.');

            // Confirm roles needed
            if ($this->command->confirm('Create Roles for user, default is admin and user? [y|N]', true)) {

                // Ask for roles from input
                $input_roles = $this->command->ask('Enter roles in comma separate format.', 'Admin,User');

                // Explode roles
                $roles_array = explode(',', $input_roles);

                // add roles
                foreach ($roles_array as $role) {
                    $role = Role::firstOrCreate(['name' => trim($role)]);
                    $this->createUser($role);

                    if ($role->name == 'Admin') {
                        // assign all permissions
                        $role->syncPermissions(Permission::all());
                        $this->command->info('Admin granted all the permissions');
                    } else {
                        // for others by default only read access
                        $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
                    }

                }

                $this->command->info('Roles ' . $input_roles . ' added successfully');
            } else {
                Role::firstOrCreate(['name' => 'User']);
                $this->createUser($role);
                $this->command->info('Added only default user role.');
            }

        }

        $user = User::first();
        $this->coreData();
        $this->command->info('Some data seeded.');
        $this->command->info('Here is your admin details to login:');
        $this->command->warn('Username is "'.$user->username.'"');
        $this->command->warn('Password is "secret"');
        $this->command->warn('All done :)');
    }

    private function coreData(){
        
        // Seed Brand
        $countData = Brand::count();
        if($countData == 0){
            for($i = 1; $i <=100; $i++){
                $faker = Faker::create();
                Brand::create([
                    "name"=>$faker->name,
                    'description'=>$faker->paragraph(10, true)
                ]);
            }     
        }
        

        // Seed Category
        $countData = Category::count();
        if($countData == 0){
            for($i = 1; $i <=100; $i++){
                $faker = Faker::create();
                Category::create([
                    "name"=>$faker->name,
                    'description'=>$faker->paragraph(10, true)
                ]);
            }
        }

         // Seed Customer
         $countData = Customer::count();
         if($countData == 0){
            for($i = 1; $i <=100; $i++){
                $faker = Faker::create();
                Customer::create([
                    "name"=>$faker->name,
                    "phone"=>$faker->phoneNumber,
                    "email"=>$faker->email,
                    "website"=>$faker->safeEmailDomain,
                    "address"=>$faker->streetAddress,
                ]);
            }
         }

         $countData = Supplier::count();
         if($countData == 0){
             // Seed Supplier
            for($i = 1; $i <=100; $i++){
                $faker = Faker::create();
                Supplier::create([
                    "name"=>$faker->name,
                    "phone"=>$faker->phoneNumber,
                    "email"=>$faker->email,
                    "website"=>$faker->safeEmailDomain,
                    "address"=>$faker->streetAddress,
                ]);
            }
         }

         $countData = Type::count();
         if($countData == 0){
              // Seed Type
                for($i = 1; $i <=100; $i++){
                    $faker = Faker::create();
                    Type::create([
                        "name"=>$faker->name,
                        'description'=>$faker->paragraph(10, true)
                    ]);
                }
         }

        $countData = Product::count();
        if($countData == 0){
            // Seed Product
            for($i = 1; $i <=100; $i++){
                $faker = Faker::create();
                $supplier = Supplier::inRandomOrder()->first();
                $type = Type::inRandomOrder()->first();
                $brand = Brand::inRandomOrder()->first();
                $categories = Category::inRandomOrder()->take(5)->get()->pluck("id")->toArray();
                $product = Product::create([
                    'sku'=>Product::createNumber(),
                    'name'=>$faker->name,
                    'brand_id'=> $brand->id,
                    'type_id'=> $type->id,
                    'supplier_id'=> $supplier->id,
                    'stock'=>0,
                    'price_purchase'=>0,
                    'price_sales'=>0,
                    'price_profit'=> 10,
                    'date_expired'=>null,
                    'description'=>$faker->paragraph(10, true),
                    'notes'=>$faker->paragraph(10, true)
                ]);
                $product->Category()->sync($categories);
            }
        }

        // Seed Supplies
        $countData = Transaction::where("type", 0)->count();
        if($countData == 0){
            for($i = 1; $i <= 100; $i++){
                $faker = Faker::create();
                $supplier = Supplier::inRandomOrder()->first();
                $casheir = User::inRandomOrder()->first();
                $customer = Customer::inRandomOrder()->first();
                $supply = Transaction::create([
                    'type'=> Transaction::SUPPLY,
                    'status'=> Transaction::PAID,
                    'invoice_number'=> Transaction::createInvoiceNumber(Transaction::SUPPLY),
                    'invoice_date'=> date("Y-m-d"),
                    'supplier_id'=> $supplier->id,
                    'casheir_id'=>$casheir->id,
                    'total_items'=>0,
                    'subtotal'=> 0,
                    'discount'=> 0,
                    'tax'=> 0,
                    'grandtotal'=> 0,
                    'cash'=> 0,
                    'change'=> 0,
                    'notes'=>$faker->paragraph(10, true)
                ]);

                $totalItems = 0;
                $subtotal = 0;

                TransactionDetail::where("transaction_id", $supply->id)->delete();

                for($j = 1; $j <= 10; $j++){
                    $product = Product::inRandomOrder()->where("stock","<=","0")->first();
                    if(!is_null($product)){
                        $exists = TransactionDetail::where("transaction_id", $supply->id)->where("product_id", $product->id)->first();
                        if(is_null($exists)){
                            $price = rand(1000,9999);
                            $qty = rand(1,99);
                            $total = $price * $qty;
                            TransactionDetail::create([
                                'transaction_id'=>$supply->id,
                                'product_id'=> $product->id,
                                'price'=> $price,
                                'qty'=> $qty,
                                'total'=> $total
                            ]);
                            $subtotal += $total;
                            $totalItems += $qty;
    
                            $product->price_purchase = $price;   
                            $product->price_sales = $price + ($price * ($product->price_profit / 100));
                            $product->supplier_id = $supplier->id;
                            $product->stock = $product->stock + $qty;
                            $product->save();
                        }
                    }

                }

                Transaction::where("id", $supply->id)->update([
                    'total_items'=>$totalItems,
                    'subtotal'=> $subtotal,
                    'grandtotal'=> $subtotal,
                    'cash'=> $subtotal
                ]);

                if($subtotal == 0){
                    DB::table("transactions")->where("id", $supply->id)->delete();
                    DB::table("transactions_details")->where("transaction_id", $supply->id)->delete();
                }

            }
        }

        // Seed Sale
        $countData = Transaction::where("type", 1)->count();
        if($countData == 0){
            for($i = 1; $i <= 100; $i++){
                $faker = Faker::create();
                $customer = Supplier::inRandomOrder()->first();
                $casheir = User::inRandomOrder()->first();
                $sale = Transaction::create([
                    'type'=> Transaction::SALES,
                    'status'=> Transaction::PAID,
                    'invoice_number'=> Transaction::createInvoiceNumber(Transaction::SALES),
                    'invoice_date'=> date("Y-m-d"),
                    'customer_id'=> $customer->id,
                    'casheir_id'=>$casheir->id,
                    'total_items'=>0,
                    'subtotal'=> 0,
                    'discount'=> 0,
                    'tax'=> 0,
                    'grandtotal'=> 0,
                    'cash'=> 0,
                    'change'=> 0,
                    'notes'=>$faker->paragraph(10, true)
                ]);

                $totalItems = 0;
                $subtotal = 0;

                TransactionDetail::where("transaction_id", $sale->id)->delete();

                for($j = 1; $j <= 10; $j++){
                    $product = Product::inRandomOrder()->where("stock",">","0")->first();
                    if(!is_null($product)){
                        $exists = TransactionDetail::where("transaction_id", $supply->id)->where("product_id", $product->id)->first();
                        if(is_null($exists)){
                            $price = $product->price_sales;
                            $qty = rand(1,10);
                            $total = $price * $qty;
                            $stock = $product->stock - $qty;
                            if($stock >= $qty){
                                TransactionDetail::create([
                                    'transaction_id'=>$sale->id,
                                    'product_id'=> $product->id,
                                    'price'=> $price,
                                    'qty'=> $qty,
                                    'total'=> $total
                                ]);
                                $subtotal += $total;
                                $totalItems += $qty;
                                $product->stock = $product->stock - $qty;
                                $product->save();
                            }
                        }
                       
                    }
                }

                Transaction::where("id", $sale->id)->update([
                    'total_items'=>$totalItems,
                    'subtotal'=> $subtotal,
                    'grandtotal'=> $subtotal,
                    'cash'=> $subtotal
                ]);

                if($subtotal == 0){
                    DB::table("transactions")->where("id", $sale->id)->delete();
                    DB::table("transactions_details")->where("transaction_id", $sale->id)->delete();
                }

            }
        }
    }

    private function createUser($role){
        $user = factory(User::class)->create();
        $user->assignRole($role->name);
        $user_id = $user->id;

        UserConfirm::create([
            'user_id'=> $user_id,
            'token'=> $user->remember_token
        ]);

        User::where("id", $user_id)->update([
            "access"=>json_encode(array($role->name))
        ]);

    }

}
