<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create some sample companies
        $companies = [
            [
                'name' => 'Tech Innovators Ltd',
                'email' => 'contact@techinnovators.com',
                'website' => 'https://www.techinnovators.com',
                'logo' => null, // or provide a path if logo is stored locally
            ],
            [
                'name' => 'Green Solutions Inc',
                'email' => 'info@greensolutions.com',
                'website' => 'https://www.greensolutions.com',
                'logo' => null,
            ],
            [
                'name' => 'Future Enterprises',
                'email' => 'hello@futureenterprises.com',
                'website' => 'https://www.futureenterprises.com',
                'logo' => null,
            ],
            [
                'name' => 'Tech Innovators Ltd',
                'email' => 'contact@techinnovators.com',
                'website' => 'https://www.techinnovators.com',
                'logo' => null, // or provide a path if logo is stored locally
            ],
            [
                'name' => 'Green Solutions Inc',
                'email' => 'info@greensolutions.com',
                'website' => 'https://www.greensolutions.com',
                'logo' => null,
            ],
            [
                'name' => 'Future Enterprises',
                'email' => 'hello@futureenterprises.com',
                'website' => 'https://www.futureenterprises.com',
                'logo' => null,
            ],
            [
                'name' => 'Tech Innovators Ltd',
                'email' => 'contact@techinnovators.com',
                'website' => 'https://www.techinnovators.com',
                'logo' => null, // or provide a path if logo is stored locally
            ],
            [
                'name' => 'Green Solutions Inc',
                'email' => 'info@greensolutions.com',
                'website' => 'https://www.greensolutions.com',
                'logo' => null,
            ],
            [
                'name' => 'Future Enterprises',
                'email' => 'hello@futureenterprises.com',
                'website' => 'https://www.futureenterprises.com',
                'logo' => null,
            ],
            [
                'name' => 'Tech Innovators Ltd',
                'email' => 'contact@techinnovators.com',
                'website' => 'https://www.techinnovators.com',
                'logo' => null, // or provide a path if logo is stored locally
            ],
            [
                'name' => 'Green Solutions Inc',
                'email' => 'info@greensolutions.com',
                'website' => 'https://www.greensolutions.com',
                'logo' => null,
            ],
            [
                'name' => 'Future Enterprises',
                'email' => 'hello@futureenterprises.com',
                'website' => 'https://www.futureenterprises.com',
                'logo' => null,
            ],
        ];

        // Insert each company into the database
        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
