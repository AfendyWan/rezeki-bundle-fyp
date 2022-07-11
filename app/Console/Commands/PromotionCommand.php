<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
class PromotionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotion:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //update data here
        $todayDateCompare = date('Y-m-d');
        $carbonParseTodayDateCompare = Carbon::parse($todayDateCompare);
      
        $getSaleItem = SaleItem::all();

     
        foreach($getSaleItem as $s){
            if($s->itemPromotionStatus == 1){
               
                $carbonItemPromotionEndDate = Carbon::parse($s->itemPromotionEndDate); 
              
                $resultDate = $carbonItemPromotionEndDate->lt($carbonParseTodayDateCompare);
        
                if ($resultDate) {
                    SaleItem::where('id', $s->id)
                    ->update([
                           'itemPromotionStatus' => 0,
                          
                    ]);
                   
                }
            }
        }
        
  
        return 0;
    }
}
