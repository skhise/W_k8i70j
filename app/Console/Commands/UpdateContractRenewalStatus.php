<?php

namespace App\Console\Commands;

use App\Models\Account_Setting;
use App\Models\Contract;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class UpdateContractRenewalStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-contract-renewal-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $today = date('Y-m-d H:i:s');
            $account_setting = Account_Setting::where("id", 1)->first();
            $renewalAlertDays = $account_setting->renewal_days;
            echo  $renewalAlertDays;
            $contracts = Contract::where('CNRT_Status','<>',3)->get();
            foreach($contracts as $contract){
                $EndDate = $contract->CNRT_EndDate;
                $ContractId = $contract->CNRT_ID;
                $from_date = Carbon::parse(date('Y-m-d', strtotime($EndDate)));
                $through_date = Carbon::parse(date('Y-m-d', strtotime($today)));
                $days_difference = $through_date->diffInDays($from_date);
                echo $ContractId."\n";
                if (Carbon::parse($from_date)->lt($through_date)) {
                    echo "hi\n";
                    $contract->CNRT_Status =3 ;
                    $contract->save();
                    //Contract::where("CNRT_ID", $ContractId)->update(['CNRT_Status' => 3]);
                } else if ($days_difference <= $renewalAlertDays) {
                    echo "hey\n";
                    $contract->CNRT_Status =2 ;
                    $contract->save();
                    // Contract::where("CNRT_ID", $ContractId)->update(['CNRT_Status' => 2]);
                } else {
                    echo "hiy\n";
                }
            }
            $this->info('Updated successfully');
        } catch (Exception $e) {
            $this->error('Error:'.$e->getMessage());
        }
        //
    }
}
