<table class="table">
    <thead>
    <tr>
        <th>Pack</th>
        <th>Units</th>
        <th>Amount (in INR)</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Single Pack</td>
        <td>{{$packageArr['singlePackUnit']}}</td>
        <td class="text-right">{{$packageArr['singlePackTotal']}}</td>
    </tr>
    <tr>
        <td>2-4 Pack</td>
        <td>{{$packageArr['towPackUnit']}}</td>
        <td class="text-right">{{$packageArr['towPackTotal']}}</td>
    </tr>
    <tr>
        <td>5-7 Pack</td>
        <td>{{$packageArr['fivePackUnit']}}</td>
        <td class="text-right">{{$packageArr['fivePackTotal']}}</td>
    </tr>
    <tr>
        <td>8-10 Pack</td>
        <td>{{$packageArr['eightPackUnit']}}</td>
        <td class="text-right">{{$packageArr['eightPackTotal']}}</td>
    </tr>
    <tr>
        <td>Above 10 Pack</td>
        <td>{{$packageArr['tenPackUnit']}}</td>
        <td class="text-right">{{$packageArr['tenPackTotal']}}</td>
    </tr>
    </tbody>
</table>