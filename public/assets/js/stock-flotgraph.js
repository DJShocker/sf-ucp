// fetch mining company initially
updateStockGraph(0, 'The Mining Company');

// called to update the stock graph
function updateStockGraph(id, title)
{
    $('#stock_title').text(title);

    $.getJSON("/api/stock/"+id).success(function(data) {
        var dz = [];

        $("#tooltip").remove();

        for (var i = 0; i < 30; i++) if (i < data['STOCK_REPORTS'].length) {
            dz.push([new Date(data['STOCK_REPORTS'][i]["DATE"] * 1000), data['STOCK_REPORTS'][i]["PRICE"]]);
        }

        $.plot("#stockGraph", [dz], {
            series: {
                shadowSize: 0,
                lines: {
                    show: true
                },
                points: {
                    show: true
                }
            },
            grid: {
                hoverable: true,
                clickable: true
            },
            colors: ["#16a085"],
            label: "Stock",
            xaxis: {
                mode: "time",
                tickSize: [1, "day"],
                timeformat: "%m/%d"
            }
        });

        var previousPoint = null;
        $("#stockGraph").bind("plothover", function(event, pos, item) {
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;
                    showTooltip(item.pageX, item.pageY, formatMoney(dz[item.dataIndex][1]))
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null
            }
        })
    });
    $("#stockGraph").css("min-height", "100px");
}

function formatMoney(number) {
  return number.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
}

function showTooltip(x, y, contents) {
    $("#tooltip").remove();
    $('<div id="tooltip">' + contents + "</div>").css({
        position: "absolute",
        display: "none",
        top: y + 5,
        left: x +
            5,
        padding: "2px",
        "background-color": "#000",
        color: "#fff",
        opacity: .75
    }).appendTo("body").fadeIn(200)
}
