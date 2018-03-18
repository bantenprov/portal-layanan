<?php

/* Require */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/* Models */
use Bantenprov\Layanan\Models\Bantenprov\Layanan\Layanan;

class BantenprovLayananSeederLayanan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
        Model::unguard();

        $layanans = (object) [
            (object) [
                'user_id' => '1',
                'group_egovernment_id' => '1',
                'label' => 'GroupEgovernment 1',
                'description' => 'GroupEgovernment satu'
            ],
            (object) [
                'user_id' => '2',
                'group_egovernment_id' => '2',
                'label' => 'GroupEgovernment 2',
                'description' => 'GroupEgovernment dua',
            ]
        ];

        foreach ($layanans as $layanan) {
            $model = Layanan::updateOrCreate(
                [
                    'user_id' => $layanan->user_id,
                    'group_egovernment_id' => $layanan->group_egovernment_id,
                    'label' => $layanan->label,
                    'description' => $layanan->description,
                ]
            );
            $model->save();
        }
	}
}
