<script src="/assets/js/google.charts.js"></script>
<script>
    function nrOfDecimals(number, fixed) {
        var match = (''+number).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
        if (!match) { return 0; }

        var decimals =  Math.max(0,
            (match[1] ? match[1].length : 0)
            // Correct the notation.
            - (match[2] ? +match[2] : 0));

        if(decimals > 8){
            //if decimal are more then 8
            number = parseFloat(number).toFixed(fixed);
        }
        //else no adjustment is needed
        return number;
    }

    function calculate()
    {
        $(document).ready(function(){
            var amount = $('#calculatorAmount').val();
            var rate = $('#calculatorRate').val();

            @foreach(\App\Models\Rate::orderBy('min')->get() as $rate)
            if (rate == '{{ $rate->id }}') {
                var duration = {{ $rate->duration }};
                var percent = {{ $rate->daily }};
                var currency = '{{ $rate->currency->code }}';
                var payout = '{{ $rate->payout }}';
            }
            @endforeach

            if (amount > 50000) {
                return false;
            }

            var perDay = amount/100*percent;
            var perPeriod = perDay*duration;

            var htmlDay = 0;
            var htmlAlltime = 0;

            if (currency == 'USD' || currency == 'RUB' || currency == 'EUR') {
                htmlDay = nrOfDecimals(perDay, 2);
                htmlAlltime = nrOfDecimals(parseFloat(perPeriod), 2)+' '+currency+' {{ __('for') }} '+ duration +' {{ __('days') }} + {{ __('body_returns') }} '+(amount/100*payout)+' '+currency;
            } else {
                htmlDay = nrOfDecimals(perDay, 8);
                htmlAlltime = nrOfDecimals(parseFloat(perPeriod), 8)+' '+currency+' {{ __('for') }} '+ duration +' {{ __('days') }} + {{ __('body_returns') }} '+(amount/100*payout)+' '+currency;
            }

            $('#calculatorResult').html(htmlAlltime);

            window.investmentStat = [];
            console.log(window.investmentStat);

            window.investmentStat[0] = ['{{ __('Value') }}', '{{ __('Investments') }}'];
            console.log(window.investmentStat);

            var grafFirstAmount = parseFloat(parseFloat(amount)+parseFloat(perDay));

            for(i=1; i<=duration; i++) {
                grafFirstAmount = parseFloat(grafFirstAmount);
                window.investmentStat[i] = [i, grafFirstAmount];
                grafFirstAmount += perDay;
            }
            console.log(window.investmentStat);

            if ($('#js-graph-trafficStatistics').length) {
                google.setOnLoadCallback(trafficStatistics);
            }
        });
    }

    calculate();

    $(document).ready(function(){
        $('#calculatorAmount').keyup(function(){
            calculate();
        });

        $('#calculatorRate').change(function(){
            calculate();
        });
    });
</script>

<script>
    // TRAFFIC STATISTICS
    google.load('visualization', '1', {
        'packages': ['corechart']
    });
    google.charts.load('current', {
        'packages': ['corechart']
    });

    // TRAFFIC STATISTICS
    function trafficStatistics() {
        var data = google.visualization.arrayToDataTable(window.investmentStat);

        var options = {
            legend: 'none',
            lineWidth: 4,
            pointSize: 12,
            'backgroundColor': 'transparent',
            chartArea: {
                left: 30,
                right: 30, // !!! works !!!
                bottom: 60, // !!! works !!!
                top: 40,
                width: "100%",
                height: "500",

            },
            series: {
                0: {
                    color: '#469ab3'
                },
            },

            vAxis: {
                title: "{{ __('Investments') }}",
                gridlines: {
                    color: '#b1b0b5',
                    count: 4,
                }
            },
            tooltip: {
                trigger: 'focus'
            },
            pointsVisible: true
        };

        var element = document.getElementById('js-graph-trafficStatistics');
        var chart = new google.visualization.LineChart(element);
        chart.draw(data, options);
    }
</script>