$(function() {
    "use strict";

    //  Use by Device
    var sharedPercentag="{{$sharedPercentage}}";
    var pendingPercentage="{{$pendingPercentage}}";
    var redeemPercentage="{{$redeemPercentage}}";
    var perE="{{$perE}}";
    var perD="{{$perD}}";
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#Properties-Analytics', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    // ['data1', 48],
                    ['data2', sharedPercentag],
                    ['data3', pendingPercentage],
                    ['data4', redeemPercentage],
                ],
                type: 'pie', // default type of chart
                colors: {
                    // 'data1': Iconic.colors["theme-cyan1"],
                    'data2': Iconic.colors["theme-cyan1"],
                    'data3': Iconic.colors["theme-cyan3"],
                    'data4': Iconic.colors["theme-cyan2"],
                },
                names: {
                    // name of each serie
                    // 'data1': 'Commercial',
                    'data2': 'Shared Coupon',
                    'data3': 'Pending Requests',
                    'data4': 'Coupon Redeemed',
                }
            },
            axis: {
            },
            legend: {
                show: false, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });

    // Gender-Ratio
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#Gender-Ratio', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', perD],
                    ['data2', perE],
                ],
                type: 'donut', // default type of chart
                colors: {
                    'data1': Iconic.colors["theme-purple1"],
                    'data2': Iconic.colors["theme-purple2"],
                },
                names: {
                    // name of each serie
                    'data1': 'Vendor Recieved',
                    'data2': 'Total Discount',
                }
            },
            axis: {
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
});
