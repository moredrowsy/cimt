<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use App\Role;
use App\User;
use App\RoleAdmin;
use App\RoleCimt;
use App\RoleResProvider;
use App\Func;
use App\Category;
use App\UnitCost;
use App\Incident;
use App\Resource;
use App\Capability;
use App\ResIncRequest;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // drop all tables
        Artisan::call('migrate:reset', ['--force' => true]);
        Artisan::call('migrate');

        // Role
        $roles = [
            [
                'name' => 'Admin',
                'table_name' => 'role_admins',
            ],
            [
                'name' => 'CIMT',
                'table_name' => 'role_cimts',
            ],
            [
                'name' => 'Resource Provider',
                'table_name' => 'role_res_providers',
            ]
        ];
        foreach ($roles as $role)
            Role::create($role);

        // User
        $users = [
            [
                'name' => 'Thuan Tang',
                'email' => 'thuantang@gmail.com',
                'role_id' => 1,
                'tel' => '123-456-7890',
                'address' => '123 Main St., Pasadena, CA 91001',
                'password' => Hash::make('test'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Simba',
                'email' => 'simba@email.com',
                'role_id' => 2,
                'tel' => '456-789-0123',
                'address' => '456 Central Ave., Pasadena, CA 91001',
                'password' => Hash::make('test'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Mufasa',
                'email' => 'mufasa@email.com',
                'role_id' => 3,
                'tel' => '789-012-3145',
                'address' => '789 Sideway Blvd., Pasadena, CA 91001',
                'password' => Hash::make('test'),
                'email_verified_at' => now(),
            ],
        ];
        foreach ($users as $user) {
            $newUser = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role_id' => $user['role_id'],
                'password' => $user['password'],
                'email_verified_at' => $user['email_verified_at'],
            ]);

            switch ($user['role_id']) {
                case 1:
                    $newUser->admin()->save(
                        new RoleAdmin(['email' => $user['email']])
                    );
                    break;
                case 2:
                    $newUser->cimt()->save(
                        new RoleCimt(['tel' => $user['tel']])
                    );
                    break;
                case 3:
                    $newUser->res_provider()->save(
                        new RoleResProvider(['address' => $user['address']])
                    );
                    break;
                default:
            }
        }

        // Func
        $funcs = [
            ['name' => 'transportation',],
            ['name' => 'communications',],
            ['name' => 'engineering',],
            ['name' => 'search and rescue',],
            ['name' => 'education',],
            ['name' => 'energy',],
            ['name' => 'firefighting',],
            ['name' => 'human services',],
        ];
        foreach ($funcs as $func)
            Func::create($func);

        // Category
        $categories = [
            ['name' => 'must evac, secure lockdown',],
            ['name' => 'may evac, secure lockdown',],
            ['name' => 'no evac, limited lockdown',],
            ['name' => 'no evac, no lockdown',],
        ];
        foreach ($categories as $category)
            Category::create($category);

        // UnitCost
        $unit_costs = [
            ['name' => 'hour',],
            ['name' => 'day',],
            ['name' => 'use',],
        ];
        foreach ($unit_costs as $unit_cost)
            UnitCost::create($unit_cost);

        // Incident
        $incidents = [
            [
                'user_id' => User::whereEmail('thuantang@gmail.com')->first()->id,
                'category_id' => Category::where('name', 'must evac, secure lockdown')->first()->id,
                'date' => '2019-09-01',
                'description' => 'Evil sorcerer on the loose!',
            ],
            [
                'user_id' => User::whereEmail('thuantang@gmail.com')->first()->id,
                'category_id' => Category::where('name', 'must evac, secure lockdown')->first()->id,
                'date' => '2019-09-05',
                'description' => 'Palace on fire!',
            ],
            [
                'user_id' => User::whereEmail('simba@email.com')->first()->id,
                'category_id' => Category::where('name', 'no evac, limited lockdown')->first()->id,
                'date' => '2019-09-20',
                'description' => 'Confirmed thief inside palace',
            ],
            [
                'user_id' => User::whereEmail('mufasa@email.com')->first()->id,
                'category_id' => Category::where('name', 'no evac, no lockdown')->first()->id,
                'date' => '2019-09-25',
                'description' => 'Elephant accident on main road',
            ],
            [
                'user_id' => User::whereEmail('mufasa@email.com')->first()->id,
                'category_id' => Category::where('name', 'no evac, no lockdown')->first()->id,
                'date' => '2019-09-25',
                'description' => 'Genie causing ruckus',
            ],
        ];
        foreach ($incidents as $incident)
            Incident::create($incident);

        // --------
        // Resource
        // --------

        // pickup truck
        $resources = [
            [
                'user_id' => User::whereEmail('thuantang@gmail.com')->first()->id,
                'name' => 'Pickup Truck',
                'pri_func_id' => Func::where('name', 'transportation')->first()->id,
                'sec_func_id' => null,
                'description' => '2016 Black Toyota Tacoma',
                'capabilities' => [
                    new Capability([
                        'name' => '1,200 lbs capacity',
                    ]),
                    new Capability([
                        'name' => '2.7L 4-cylinder gas',
                    ])
                ],
                'distance' => '9.3',
                'cost' => '249.99',
                'unit_cost_id' => UnitCost::where('name', 'day')->first()->id,
            ],
            // cargo van
            [
                'user_id' => User::whereEmail('thuantang@gmail.com')->first()->id,
                'name' => 'Cargo Van',
                'pri_func_id' => Func::where('name', 'transportation')->first()->id,
                'sec_func_id' => null,
                'description' => '2018 Gray Ford Transit-350 Caro',
                'capabilities' => [
                    new Capability([
                        'name' => '3,700 lbs capacity',

                    ]),
                    new Capability([
                        'name' => 'interior padding',

                    ]),
                    new Capability([
                        'name' => '2L 4-cylinder diesel',

                    ]),
                ],
                'distance' => '3.2',
                'cost' => '399.99',
                'unit_cost_id' => UnitCost::where('name', 'day')->first()->id,
            ],
            // ambulance
            [
                'user_id' => User::whereEmail('simba@email.com')->first()->id,
                'name' => 'Ambulance',
                'pri_func_id' => Func::where('name', 'search and rescue')->first()->id,
                'sec_func_id' => Func::where('name', 'transportation')->first()->id,
                'description' => '2016 Red Marque Ford',
                'capabilities' => [
                    new Capability([
                        'name' => '6+ years experience',

                    ]),
                    new Capability([
                        'name' => 'Safety and comfort',

                    ]),
                ],
                'distance' => '2.9',
                'cost' => '599.99',
                'unit_cost_id' => UnitCost::where('name', 'use')->first()->id,
            ],
            // helicopter
            [
                'user_id' => User::whereEmail('mufasa@email.com')->first()->id,
                'name' => 'Helicopters',
                'pri_func_id' => Func::where('name', 'search and rescue')->first()->id,
                'sec_func_id' => Func::where('name', 'transportation')->first()->id,
                'description' => 'Agusta AW109S Grand',
                'capabilities' => [
                    new Capability([
                        'name' => '6 passengers',

                    ]),
                    new Capability([
                        'name' => 'Comfortable and roomy',

                    ]),
                ],
                'distance' => '6.1',
                'cost' => '350',
                'unit_cost_id' => UnitCost::where('name', 'hour')->first()->id,
            ],
            // airplance
            [
                'user_id' => User::whereEmail('simba@email.com')->first()->id,
                'name' => 'Air Tanker',
                'pri_func_id' => Func::where('name', 'firefighting')->first()->id,
                'sec_func_id' => null,
                'description' => 'DC-10 Air Tanker',
                'capabilities' => [
                    new Capability([
                        'name' => 'Cruisng speed 520 knots',

                    ]),
                    new Capability([
                        'name' => '11,600 gallons capacity',

                    ]),
                ],
                'distance' => null,
                'cost' => '16500',
                'unit_cost_id' => UnitCost::where('name', 'hour')->first()->id,
            ],
            [
                'user_id' => User::whereEmail('thuantang@gmail.com')->first()->id,
                'name' => 'Genie',
                'pri_func_id' => Func::where('name', 'human services')->first()->id,
                'sec_func_id' => Func::where('name', 'engineering')->first()->id,
                'description' => '2nd Gen Blue Genie',
                'capabilities' => [
                    new Capability([
                        'name' => 'Grants 3 wish except granting more wishes',

                    ]),
                    new Capability([
                        'name' => 'Most powerful being except for lamp',

                    ]),
                    new Capability([
                        'name' => '100% guarantee',

                    ]),
                ],
                'distance' => '1.8',
                'cost' => '999999',
                'unit_cost_id' => UnitCost::where('name', 'use')->first()->id,
            ],
            [
                'user_id' => User::whereEmail('thuantang@gmail.com')->first()->id,
                'name' => 'Aladdin',
                'pri_func_id' => Func::where('name', 'human services')->first()->id,
                'sec_func_id' => Func::where('name', 'transportation')->first()->id,
                'description' => 'Street slick thief',
                'capabilities' => [
                    new Capability([
                        'name' => 'Can "borrow" almost anything!',

                    ]),
                    new Capability([
                        'name' => '99% guarantee',

                    ]),
                ],
                'distance' => '1.8',
                'cost' => '100',
                'unit_cost_id' => UnitCost::where('name', 'use')->first()->id,
            ],
            [
                'user_id' => User::whereEmail('thuantang@gmail.com')->first()->id,
                'name' => 'Abu',
                'pri_func_id' => Func::where('name', 'transportation')->first()->id,
                'sec_func_id' => null,
                'description' => 'Brown agile monkey',
                'capabilities' => [
                    new Capability([
                        'name' => 'Can "borrow" almost anything!',

                    ]),
                    new Capability([
                        'name' => '100% guarantee',

                    ]),
                ],
                'distance' => '1.8',
                'cost' => '200',
                'unit_cost_id' => UnitCost::where('name', 'use')->first()->id,
            ],

            [
                'user_id' => User::whereEmail('thuantang@gmail.com')->first()->id,
                'name' => 'Jasmine',
                'pri_func_id' => Func::where('name', 'communications')->first()->id,
                'sec_func_id' => Func::where('name', 'education')->first()->id,
                'description' => 'Princess of Agrabah',
                'capabilities' => [
                    new Capability([
                        'name' => 'Sneaking around kingdom and talk to people',

                    ]),
                    new Capability([
                        'name' => 'Try to educate the populace',

                    ]),
                ],
                'distance' => '1',
                'cost' => '0',
                'unit_cost_id' => UnitCost::where('name', 'use')->first()->id,
            ],
            [
                'user_id' => User::whereEmail('simba@email.com')->first()->id,
                'name' => 'Jafar',
                'pri_func_id' => Func::where('name', 'energy')->first()->id,
                'sec_func_id' => Func::where('name', 'human services')->first()->id,
                'description' => 'Vizier aka Evil Sorcerer',
                'capabilities' => [
                    new Capability([
                        'name' => 'Human mind control',

                    ]),
                    new Capability([
                        'name' => 'Pyrokinesis',

                    ]),
                    new Capability([
                        'name' => 'Shapeshifting',

                    ]),
                ],
                'distance' => '1',
                'cost' => '666',
                'unit_cost_id' => UnitCost::where('name', 'day')->first()->id,
            ],
            [
                'user_id' => User::whereEmail('simba@email.com')->first()->id,
                'name' => 'The Sultan',
                'pri_func_id' => Func::where('name', 'human services')->first()->id,
                'sec_func_id' => Func::where('name', 'human services')->first()->id,
                'description' => 'Ruler of Agrabah',
                'capabilities' => [
                    new Capability([
                        'name' => 'Easily manipulated by vizier',

                    ]),
                ],
                'distance' => '1',
                'cost' => '0',
                'unit_cost_id' => UnitCost::where('name', 'day')->first()->id,
            ]
        ];
        foreach ($resources as $resource) {
            Resource::create([
                'name' => $resource['name'],
                'user_id' => $resource['user_id'],
                'pri_func_id' => $resource['pri_func_id'],
                'sec_func_id' => $resource['sec_func_id'],
                'description' => $resource['description'],
                'distance' => $resource['distance'],
                'cost' => $resource['cost'],
                'unit_cost_id' => $resource['unit_cost_id'],
            ])->capabilities()->saveMany($resource['capabilities']);
        }

        // --------
        // Resource-Incident Requests
        // --------

        // Resource: 'Pickup Truck' requests Incident: 'Confirmed thief inside palace'
        $resource = Resource::where('name', 'Pickup Truck')->first();
        $incident = Incident::where('description', 'Confirmed thief inside palace')->first();
        $requester_id = $resource->user_id;
        $requestee_id = $incident->user_id;
        ResIncRequest::create([
            'requester_id' => $requester_id,
            'requestee_id' => $requestee_id,
            'resource_id' => $resource->id,
            'incident_id' => $incident->id,
            'status' => 'Pending',
        ]);

        // Incident: 'Evil sorcerer on the loose!' requests Resource: 'Helicopters 	'
        $resource = Resource::where('name', 'Helicopters')->first();
        $incident = Incident::where('description', 'Evil sorcerer on the loose!')->first();
        $requester_id = $incident->user_id;
        $requestee_id = $resource->user_id;
        ResIncRequest::create([
            'requester_id' => $requester_id,
            'requestee_id' => $requestee_id,
            'resource_id' => $resource->id,
            'incident_id' => $incident->id,
            'status' => 'Pending',
        ]);
    }
}
