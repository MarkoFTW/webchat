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
    }

    $.getJSON("./pages/data/dataCountry.php", function(json) {
        options.series[0].data = json;
        chart = new Highcharts.Chart(options);
    });

///////////////////////////// CHART 2 //////////////////////
   var options1 = {
        chart: {
            backgroundColor: 'transparent',
            renderTo: 'containerSocial',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        credits: {
            enabled: false
        },
        title: {
            style: {
                color: '#FFFFFF',
                font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
             },
            text: 'User social login statistics'
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
            name: 'Social logins',
            data: []
        }]
    }

    $.getJSON("./pages/data/dataSocial.php", function(json) {
        options1.series[0].data = json;
        chart = new Highcharts.Chart(options1);
    });
});   