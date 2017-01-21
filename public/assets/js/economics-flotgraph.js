$(function() {
    var dz = [];
    $.getJSON("/api/cashstats").success(function(data) {
        for (var i = 0; i < 30; i++) {
            dz.push([new Date(data[i]["date"] * 1000), data[i]["cash"]]);
        }
        $.plot("#cashPrinted", [dz], {
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
            colors: ["#539F2E"],
            label: "Total Cash",
            xaxis: {
                mode: "time",
                tickSize: [2, "day"],
                timeformat: "%m/%d"
            }
        });

        function showTooltip(x, y, contents) {
            $('<div id="tooltip">' + contents + "</div>").css({
                position: "absolute",
                display: "none",
                top: y + 5,
                left: x +
                    5,
                padding: "2px",
                "background-color": "#000",
                color: "#fff",
                opacity: .8
            }).appendTo("body").fadeIn(200)
        }

        var previousPoint = null;
        $("#cashPrinted").bind("plothover", function(event, pos, item) {
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;
                    showTooltip(item.pageX, item.pageY, dz[item.dataIndex][1])
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null
            }
        })
    });
    $("#cashPrinted").css("min-height", "100px")
});
