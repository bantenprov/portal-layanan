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
                'kegiatan_id' => '1',
                'label' => 'Kegiatan 1',
                'description' => 'Kegiatan satu'
            ],
            (object) [
                'user_id' => '2',
                'kegiatan_id' => '2',
                'label' => 'Kegiatan 2',
                'description' => 'Kegiatan dua',
            ]
        ];

        foreach ($layanans as $layanan) {
            $model = Layanan::updateOrCreate(
                [
                    'user_id' => $layanan->user_id,
                    'kegiatan_id' => $layanan->kegiatan_id,
                    'label' => $layanan->label,
                    'description' => $layanan->description,
                ]
            );
            $model->save();
        }
	}
}
