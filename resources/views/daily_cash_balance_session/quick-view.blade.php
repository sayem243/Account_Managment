<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body" style="padding-top: 5px">
                    <h3 style="text-align: center">Date: {{ date('d-m-Y', strtotime($selected_date))}}</h3>
                    <table class= "table">
                        <thead>
                        <tr style="font-weight: bold">
                            <td>Company Name</td>
                            <td>Opening Balance</td>
                            <td>Debit</td>
                            <td>Credit</td>
                            <td>Closing Balance</td>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $totalOpeningBalance = 0;
                            $crTotal = 0;
                            $drTotal = 0;
                            $totalClosingBalance = 0;
                        @endphp
                        @foreach($companies as  $companyId=>$company)
                            @php
                                $openingBalance= isset($openingClosingBalance[$companyId])?$openingClosingBalance[$companyId]->opening_balance:0;
                                $totalOpeningBalance = $totalOpeningBalance+$openingBalance;
                                $dailyDr=isset($cashTransactions[$companyId]['DR'])?array_sum($cashTransactions[$companyId]['DR']):0;
                                $drTotal=$drTotal+$dailyDr;
                                $dailyCr = isset($cashTransactions[$companyId]['CR'])?array_sum($cashTransactions[$companyId]['CR']):0;
                                $crTotal = $crTotal+$dailyCr;
                                $closingBalance= isset($openingClosingBalance[$companyId])?$openingClosingBalance[$companyId]->closing_balance:0;
                                $totalClosingBalance = $totalClosingBalance+$closingBalance;
                            @endphp

                            @if($openingBalance>0 || $dailyCr>0)
                            <tr>
                                <td>{{$company}}</td>
                                <td>{{number_format($openingBalance,2,'.',',')}}</td>
                                <td>{{number_format($dailyDr,2,'.',',')}}</td>
                                <td>{{number_format($dailyCr,2,'.',',')}}</td>
                                <td>{{number_format($closingBalance,2,'.',',')}}</td>
                            </tr>
                            @endif

                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="font-weight: bold">
                                <td>Total</td>
                                <td>{{number_format($totalOpeningBalance,2,'.',',')}}</td>
                                <td>{{number_format($drTotal,2,'.',',')}}</td>
                                <td>{{number_format($crTotal,2,'.',',')}}</td>
                                <td>{{number_format($totalClosingBalance,2,'.',',')}}</td>
                            </tr>
                        </tfoot>

                    </table>
                </div>





            </div>
        </div>

    </div>
</div>
