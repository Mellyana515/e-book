<?php

namespace Database\Seeders;

use App\Models\Ebook;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@ebook.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Sample user
        User::create([
            'name'     => 'John Doe',
            'email'    => 'user@ebook.com',
            'password' => Hash::make('user1234'),
            'role'     => 'user',
        ]);

        // Sample ebooks
        $ebooks = [
            [
                'title'       => 'Laravel: Up & Running',
                'description' => 'A complete guide to the Laravel PHP framework. Learn to build modern web applications with Laravel from the ground up. Covers routing, Eloquent ORM, Blade templating, queues, and more.',
                'author'      => 'Matt Stauffer',
                'price'       => 29.99,
                'category'    => 'Programming',
                'status'      => 'published',
            ],
            [
                'title'       => 'Clean Code',
                'description' => "A Handbook of Agile Software Craftsmanship. Even bad code can function. But if code isn't clean, it can bring a development organization to its knees. This book is a must-read for any developer.",
                'author'      => 'Robert C. Martin',
                'price'       => 24.99,
                'category'    => 'Programming',
                'status'      => 'published',
            ],
            [
                'title'       => 'The Pragmatic Programmer',
                'description' => 'Your Journey to Mastery. This book will help you become a better programmer. Topics range from personal responsibility to career development, and include architectural techniques to keep code flexible.',
                'author'      => 'David Thomas & Andrew Hunt',
                'price'       => 34.99,
                'category'    => 'Programming',
                'status'      => 'published',
            ],
            [
                'title'       => 'JavaScript: The Good Parts',
                'description' => 'Most programming languages contain good and bad parts, but JavaScript has more than its share of the bad. This book identifies the goodness in JavaScript that makes it work well.',
                'author'      => 'Douglas Crockford',
                'price'       => 19.99,
                'category'    => 'Web Development',
                'status'      => 'published',
            ],
            [
                'title'       => 'Python Crash Course',
                'description' => "A Hands-On, Project-Based Introduction to Programming. Python Crash Course is the world's best-selling guide to the Python programming language.",
                'author'      => 'Eric Matthes',
                'price'       => 22.99,
                'category'    => 'Programming',
                'status'      => 'published',
            ],
            [
                'title'       => 'Design Patterns',
                'description' => 'Elements of Reusable Object-Oriented Software. Capturing a wealth of experience about the design of object-oriented software, four top-notch designers present a catalog of simple and succinct solutions.',
                'author'      => 'Gang of Four',
                'price'       => 39.99,
                'category'    => 'Software Architecture',
                'status'      => 'published',
            ],
            [
                'title'       => 'CSS: The Definitive Guide',
                'description' => "If you're a web designer or app developer interested in sophisticated page styling, improved accessibility, and saving time and effort, this comprehensive guide is essential reading.",
                'author'      => 'Eric A. Meyer',
                'price'       => 18.99,
                'category'    => 'Web Development',
                'status'      => 'published',
            ],
            [
                'title'       => 'Domain-Driven Design',
                'description' => "Tackling Complexity in the Heart of Software. This is not a book about specific technologies. It's about how you think about the problems you're solving.",
                'author'      => 'Eric Evans',
                'price'       => 44.99,
                'category'    => 'Software Architecture',
                'status'      => 'draft',
            ],
        ];

        foreach ($ebooks as $data) {
            $slug = Str::slug($data['title']);
            Ebook::create(array_merge($data, ['slug' => $slug]));
        }
    }
}
