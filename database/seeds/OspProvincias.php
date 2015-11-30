<?php

use Illuminate\Database\Seeder;

class OspProvincias extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    	$default = (int) 901001;

		for ($i = 1; $i <= 24; $i++)
		{
			if ($i < 10)
			{
				$prov = '0'.$i;
			}
			else
			{
				$prov = (string) $i;
			}

			if ($prov == '18')
			{
				Schema::table('osp.osp_'.$prov, function(Blueprint $table)
				{
					$table->integer('codigo_os')->unsigned()->nullable();
				});
			}
			else
			{
				\DB::statement('ALTER TABLE osp.osp_'.$prov.' ADD COLUMN codigo_os integer DEFAULT '.$default);
			}

			if ($prov == '01')
			{
				
			}

			$default += 1000;
		}
	}

        \DB::statement("  ");
    }
}
