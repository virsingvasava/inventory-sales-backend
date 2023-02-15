<table class="table">
    <thead>
    <tr>
        <th>Pack</th>
        <th class="text-center">Unit</th>
        <th class="text-center">Transactions</th>
        <th class="text-center">Amount (in INR)</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Single Pack</td>
        <td style="text-align: center;">{{$packageArr['singleTransactions']}}</td>
        <td style="text-align: center;">{{$packageArr['singlePackUnit']}}</td>
        <td class="text-right" style="text-align: center;">{{$packageArr['singlePackTotal']}}</td>
    </tr>
    <tr>
        <td>2-4 Pack</td>
        <td style="text-align: center;">{{$packageArr['towTransactions']}}</td>
        <td style="text-align: center;">{{$packageArr['towPackUnit']}}</td>
        <td class="text-right" style="text-align: center;">{{$packageArr['towPackTotal']}}</td>
    </tr>
    <tr>
        <td>5-7 Pack</td>
        <td style="text-align: center;">{{$packageArr['fiveTransactions']}}</td>
        <td style="text-align: center;">{{$packageArr['fivePackUnit']}}</td>
        <td class="text-right" style="text-align: center;">{{$packageArr['fivePackTotal']}}</td>
    </tr>
    <tr>
        <td>8-10 Pack</td>
        <td style="text-align: center;">{{$packageArr['eightTransactions']}}</td>
        <td style="text-align: center;">{{$packageArr['eightPackUnit']}}</td>
        <td class="text-right" style="text-align: center;">{{$packageArr['eightPackTotal']}}</td>
    </tr>
    <tr>
        <td>Above 10 Pack</td>
        <td style="text-align: center;">{{$packageArr['tenTransactions']}}</td>
        <td style="text-align: center;">{{$packageArr['tenPackUnit']}}</td>
        <td class="text-right" style="text-align: center;">{{$packageArr['tenPackTotal']}}</td>
    </tr>
    </tbody>
</table>

<div class="modal fade" id="purchasebehaviourexport" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-size:20px">Are You sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to Export Purchase Behaviour ?</h5>
                <form action="{{ route('admin.dashboard.ajax_purchase_behaviour_export') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="startDate" value="{{$startNewDate}}"><input type="hidden" name="endDate" value="{{$endNewDate}}">
                    <input type="hidden" name="export_kiosk_data">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm hide_after_exportss">Export</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>