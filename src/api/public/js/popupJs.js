$(document).ready(function () {
    console.log("hello jquery");

    // $('#result').on("click", function () {
    //     console.log("reached destination");
    //     $.ajax({
    //         url: "/api/item/" + e,
    //         method: "POST",
    //         async: false,
    //     }).done(function (data) {
    //         //console.log(data);
    //         item = JSON.parse(data);
    //         console.log(item);
    //     });
    // });






});


function abc(id) {
    console.log(id);
    $.ajax({
        url: "/api/item/" + id,
        method: "POST",
        async: false,
    }).done(function (data) {
        //console.log(data);
        item = JSON.parse(data);
        console.log(item);
        popupDisplay(item);
    });
}

function popupDisplay(item)
{
    var v_data = `<dl class="row fw-bolder pl-3 d-flex text-wrap">`;
    variationData = item['variationData'];
    console.log(variationData.length);
    
    // for(i=0;i<variationData.length;i++)
    // {
        //     popupDisplay +=`<dt class="col-sm-3">${variationData[0]}</dt>
        //     <dd class="col-sm-9">${}</dd>`;
        // }
        metaData = item['metaData'];
        key = Object.keys(item['metaData']);
        values =Object.values(item['metaData']);
        console.log(values.length);
        var popupDisplay = ` <dl class="row fw-bolder pl-3 d-flex text-wrap">`;
    for(i=0;i<values.length;i++)
    {
        popupDisplay +=`<dt class="col-sm-3">${key[i]}</dt>
        <dd class="col-sm-9">${values[i]}</dd>`;
    }
    popupDisplay +=`</dl>`;
    document.getElementById("popupMetaBody").innerHTML = popupDisplay;
}