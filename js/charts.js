$(document).ready(function() {
    var options = {
        chart: {
            backgroundColor: 'transparent',
            renderTo: 'containerCountry',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: true,
        },
        title: {
            style: {
                color: '#FFFFFF',
                font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
             },
            text: 'User country statistics'
        },
        tooltip: {
            formatter: function() {
                return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#FFFFFF',
                    connectorColor: '#FFFFFF',
                    formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: []
        }]
    };

    $.getJSON("./pages/data/dataCountry.php", function(json) {
        options.series[0].data = json;
        chart = new Highcharts.Chart(options);
    });

///////////////////////////// CHART 2 //////////////////////
    var options1 = {
        chart: {
            backgroundColor: 'transparent',
            renderTo: 'containerSocial',
            type: 'column',
            marginRight: 130,
            marginBottom: 25
        },
        credits: {
            enabled: false
        },
        title: {
            style: {
                color: '#FFFFFF',
                font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
             },
            text: 'User login statistics',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: [],
            text: "test"
        },
        yAxis: {
            title: {
                style: {
                    color: '#FFFFFF',
                    font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                 },
                text: 'Number of users'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#FFFFFF'
            }]
        },
        tooltip: {
            formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                    this.x +': '+ this.y;
            }
        },
        legend: {
            backgroundColor: "white",
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -10,
            y: 100,
            borderWidth: 0
        },
        series: []
    };

    $.getJSON("./pages/data/dataSocial.php", function(json) {
            options1.xAxis.categories = json[0]['data'];
            options1.series[0] = json[1];
            chart = new Highcharts.Chart(options1);
    });






});   