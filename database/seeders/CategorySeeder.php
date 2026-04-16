<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Food;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Pizza', 'description' => 'Delicious pizzas with various toppings'],
            ['name' => 'Burgers', 'description' => 'Juicy burgers with fresh ingredients'],
            ['name' => 'Biryani', 'description' => 'Aromatic biryani with tender meat'],
            ['name' => 'Beverages', 'description' => 'Refreshing drinks and beverages'],
            ['name' => 'Desserts', 'description' => 'Sweet treats and desserts'],
            ['name' => 'Pasta', 'description' => 'Authentic Italian pasta dishes'],
            ['name' => 'Salads', 'description' => 'Fresh and healthy salads'],
            ['name' => 'Seafood', 'description' => 'Fresh seafood delicacies'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Get category IDs
        $pizzaCat = Category::where('name', 'Pizza')->first();
        $burgerCat = Category::where('name', 'Burgers')->first();
        $biryaniCat = Category::where('name', 'Biryani')->first();
        $beveragesCat = Category::where('name', 'Beverages')->first();
        $dessertsCat = Category::where('name', 'Desserts')->first();
        $pastaCat = Category::where('name', 'Pasta')->first();

        // Foods WITH Variants (Multiple)
        $variantFoods = [
            [
                'name' => 'Margherita Pizza',
                'description' => 'Fresh mozzarella, tomato sauce, and basil on thin crust',
                'variant_type' => 'multiple',
                'variants' => json_encode([
                    ['name' => 'Quarter', 'price' => 99],
                    ['name' => 'Half', 'price' => 149],
                    ['name' => 'Full', 'price' => 249]
                ]),
                'category_id' => $pizzaCat->id,
                'price' => null
            ],
            [
                'name' => 'Pepperoni Pizza',
                'description' => 'Classic pepperoni, mozzarella, and tomato sauce',
                'variant_type' => 'multiple',
                'variants' => json_encode([
                    ['name' => 'Quarter', 'price' => 119],
                    ['name' => 'Half', 'price' => 179],
                    ['name' => 'Full', 'price' => 299]
                ]),
                'category_id' => $pizzaCat->id,
                'price' => null
            ],
            [
                'name' => 'Chicken Biryani',
                'description' => 'Aromatic basmati rice with tender chicken and exotic spices',
                'variant_type' => 'multiple',
                'variants' => json_encode([
                    ['name' => 'Quarter', 'price' => 149],
                    ['name' => 'Half', 'price' => 249],
                    ['name' => 'Full', 'price' => 449]
                ]),
                'category_id' => $biryaniCat->id,
                'price' => null
            ],
            [
                'name' => 'Mutton Biryani',
                'description' => 'Rich and flavorful mutton biryani cooked with aromatic spices',
                'variant_type' => 'multiple',
                'variants' => json_encode([
                    ['name' => 'Quarter', 'price' => 199],
                    ['name' => 'Half', 'price' => 349],
                    ['name' => 'Full', 'price' => 599]
                ]),
                'category_id' => $biryaniCat->id,
                'price' => null
            ],
            [
                'name' => 'Pasta Alfredo',
                'description' => 'Creamy parmesan cheese sauce with fettuccine',
                'variant_type' => 'multiple',
                'variants' => json_encode([
                    ['name' => 'Regular', 'price' => 179],
                    ['name' => 'Large', 'price' => 279]
                ]),
                'category_id' => $pastaCat->id,
                'price' => null
            ],
        ];

        foreach ($variantFoods as $food) {
            Food::create($food);
        }

        // Foods WITHOUT Variants (Simple)
        $simpleFoods = [
            [
                'name' => 'Classic Cheeseburger',
                'description' => 'Beef patty, cheddar cheese, lettuce, tomato, and pickles',
                'variant_type' => 'none',
                'price' => 129,
                'category_id' => $burgerCat->id
            ],
            [
                'name' => 'Chicken Burger',
                'description' => 'Grilled chicken breast with lettuce, mayo, and pickles',
                'variant_type' => 'none',
                'price' => 149,
                'category_id' => $burgerCat->id
            ],
            [
                'name' => 'Veggie Burger',
                'description' => 'Plant-based patty with avocado, sprouts, and vegan sauce',
                'variant_type' => 'none',
                'price' => 119,
                'category_id' => $burgerCat->id
            ],
            [
                'name' => 'Coca Cola',
                'description' => 'Refreshing cola drink served with ice',
                'variant_type' => 'none',
                'price' => 49,
                'category_id' => $beveragesCat->id
            ],
            [
                'name' => 'Fresh Lemonade',
                'description' => 'Homemade lemonade with mint leaves',
                'variant_type' => 'none',
                'price' => 79,
                'category_id' => $beveragesCat->id
            ],
            [
                'name' => 'Chocolate Cake',
                'description' => 'Rich chocolate cake with ganache frosting',
                'variant_type' => 'none',
                'price' => 99,
                'category_id' => $dessertsCat->id
            ],
            [
                'name' => 'Cheesecake',
                'description' => 'New York style cheesecake with berry sauce',
                'variant_type' => 'none',
                'price' => 119,
                'category_id' => $dessertsCat->id
            ],
        ];

        foreach ($simpleFoods as $food) {
            Food::create($food);
        }

        $this->command->info('Categories and Foods seeded successfully!');
        $this->command->info('Variant foods: ' . count($variantFoods));
        $this->command->info('Simple foods: ' . count($simpleFoods));
    }
}