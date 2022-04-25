console.log("hello'");

var count = 0;
var variationFieldCount = 0;
// var fields;
// var additionalField = [];
var array = [];
function add() {
    if (count < 0)
        count = 0;

    
    var fields = ""
    
    fields = `<div id="additionalField-${count}"><label class="p-2" >Label Name ${count} <input type="text" name="l_name${count}" ></label>
         <label class="p-2" >Label Value ${count}<input type="text" name="l_value${count}" ></label></div>`;
    
    var exact_count = ` <input type="number" name="metaCount" value="${count}">`;
    document.getElementById('exact-meta-count').innerHTML = exact_count;
    count++;
    document.getElementById('additionalFields').innerHTML += fields;

}
function subtract() {
    // count--;
    // var fields ="";
    // for(i=1;i<=count;i++)
    // {
    //     fields +=`<label class="p-2">Label Name ${i} <input type="text" name="l_name${i}" ></label>
    //     <label class="p-2">Label Value ${i}<input type="text" name="l_value${i}" ></label>`;
    // }
    // fields += `<input name="metaCount" value="${count}" style="display:none">`;
    // // console.log(count);
    // document.getElementById('additionalFields').innerHTML=fields;
    // console.log("subtract");
    if (count < 0)
        count = 0;
        document.getElementById("additionalField-" + (--count)).remove();
        var exact_count = ` <input type="number" name="metaCount" value="${count-1}">`;
        document.getElementById('exact-meta-count').innerHTML = exact_count;
}
// function addVariationField()
// {
//     variationFieldCount++;
//     var variationFields = "";
//     for(i=1;i<=variationFieldCount;i++)
//     {
//         variationFields +=`<div class="d-flex justify-content-around"><label class="p-2">Attribute Name ${i} <input type="text" name="a_name${i}" ></label>
//         <label class="p-2">Attribute Value ${i}<input type="text" name="a_value${i}" ></label>
//         <label class="p-2">Price ${i} <input type="text" name="a_price${i}" ></label>
//         </div>`;
//     }
//     variationFields += `<input name="variationCount" value="${variationFieldCount}" style="display:none">`;
//     // console.log(variationFieldCount);
//     document.getElementById('variationFields').innerHTML=variationFields;

// }
// function subtractVariationField()
// {
//     variationFieldCount--;
//     var variationFields = "";
//     for(i=1;i<=variationFieldCount;i++)
//     {
//         variationFields +=`<div class="d-flex justify-content-around"><label class="p-2">Attribute Name ${i} <input type="text" name="a_name${i}" ></label>
//         <label class="p-2">Attribute Value ${i}<input type="text" name="a_value${i}" ></label>
//         <label class="p-2">Price ${i} <input type="text" name="a_price${i}" ></label>
//         </div>`;
//     }
//     variationFields += `<input name="variationCount" value="${variationFieldCount}" style="display:none">`;
//     // console.log(variationFieldCount);
//     document.getElementById('variationFields').innerHTML=variationFields;


// }


function addVariationField() {
    console.log("reached");
    if (variationFieldCount < 0)
        variationFieldCount = 0;

    var variationFields = "";

    variationFields = `<div class="d-flex justify-content-around" id="variation-${variationFieldCount}"><label class="p-2">Variation Name ${variationFieldCount} </label>
    <div class="d-flex justify-content-around">
    <p>
    <ion-icon name="add-circle-outline" size="large" id="plus" onclick=addFieldInVariationField(${variationFieldCount})></ion-icon>
    </p>
    <p>
    <ion-icon name="remove-circle-outline" size="large" id="subtract" onclick=subtractFieldFromVariationField(${variationFieldCount})></ion-icon>
    </p>
    </div>
    <div id="variation-field-content-${variationFieldCount}">
    </div>
    <div class="d-flex flex-column" id="variation-price-${variationFieldCount}">
     <label>Price<input type="number" name="a_price-${variationFieldCount}"></label>
    </div>
   
    </div>
    `;
    array[variationFieldCount] = 0;
    var exact_count = ` <input type="number" name="variationCount" value="${variationFieldCount}">`;
    document.getElementById('exact-variation-count').innerHTML = exact_count;
    variationFieldCount++;
    document.getElementById('variationFields').innerHTML += variationFields;
    

}

function subtractVariationField() {
    if (variationFieldCount < 0)
        variationFieldCount = 0;
        // this.subtractVariationPrice();
    document.getElementById("variation-" + (--variationFieldCount)).remove();
    var exact_count = `<input type="number" name="variationCount" value="${variationFieldCount-1}">`;
    document.getElementById('exact-variation-count').innerHTML = exact_count;
   
}
// function subtractVariationPrice()
// {
//     document.getElementById('variaton-price-'+(variationFieldCount-1)).remove();
// }
function addFieldInVariationField(vCount) {
    if (array[vCount] < 0 )
    array[vCount] = 0;
    console.log(vCount);
    array[vCount]++;
    console.log(array);
    var v_add = "";
    
    v_add = `<div id="feild-variation-content-${vCount}-${array[vCount]}"><label class="p-2">Name ${array[vCount]}<input type="text" name="a_name-${vCount}-${array[vCount]}" ></label>
    <label class="p-2">Value ${array[vCount]} <input type="text" name="a_value-${vCount}-${array[vCount]}" ></label></div>`;
    document.getElementById('variation-field-content-'+vCount).innerHTML+=v_add;
    

    this.check();

}
function subtractFieldFromVariationField(vCount) {
    console.log(vCount);
    // <label class="p-2">Attribute Value ${variationFieldCount}<input type="text" name="a_value${variationFieldCount}" ></label>
    // <label class="p-2">Price ${variationFieldCount} <input type="text" name="a_price${variationFieldCount}" ></label>
    // var x= array[vCount];
    // array[vCount]--
    
    document.getElementById('feild-variation-content-'+vCount+'-'+array[vCount]--).remove();
    console.log(array);
    this.check();
}




function check()
{
    var exact_count = '';
    for(i=0;i<array.length;i++)
    {
        exact_count +=`<input type="number" name="variation-f-count-${i}" value="${array[i]}">`;
    }
    document.getElementById('exact-v-f-count').innerHTML = exact_count;
}









