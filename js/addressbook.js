/* 
 * @ author: rehan@itlinkonline.com
 * @ date created: 20th December, 2009
 */

function DuplicateBox(id){
    $('#'+id)
    .clone(true)
    .attr('id','')
    .show()
    .insertBefore('#'+id)
    .children('a.remove').show()
    .parent()
    .children('input:checkbox, input:radio').attr('checked','')
    .parent()
    .children('input:text').val('');
}

function Toggle(elem, value){
    var allboxes = $('input:hidden[name='+ $(elem).attr('name') +']').val('0');
    $(elem).val(value)
//alert('element : ' + $(elem).attr('name') + '=' + $(elem).val() + '\nfound boxes : ' + allboxes.attr('name') + '=' + allboxes.val());
}

function markPrimary(elem){
    $('.primary:checkbox[name='+$(elem).attr('name')+']')
    .attr('checked','')
    .parent('label')
    .parent('div')
    .children('.input')
    .css('border','2px solid #ccc');

    $(elem).attr('checked','checked');
    $(elem).parent('label').parent('div').children('.input').css('border','2px solid #f99');
    Toggle($(elem).prev(),1);
}

function enableRadioButton(elem){
    var radioButton = $(elem).parent('div').children().children('.primary:radio, .primary:checkbox');
    //alert($(elem).parent('div').html());
    if($(elem).val()!=''){
        radioButton.attr('disabled','').attr('enabled','enabled');
    }else{
        radioButton.attr('disabled','disabled').attr('checked','');
    }
}

//
// Select All/None items
//
function MassSelection() {

    select_count = document.getElementsByName("selected[]").length;
    all_checked  = document.getElementById("MassCB").checked;

    for (i = 0; i < select_count; i++) {
        // select only visible items
        if( document.getElementsByName("selected[]")[i].parentNode.parentNode.style.display != "none") {
            document.getElementsByName("selected[]")[i].checked = all_checked;
        }
    }
}

function Doodle() {

    var participants = "";
    var dst_count = 0;

    select_count = document.getElementsByName("selected[]").length;
    for (i = 0; i < select_count; i++) {
        selected_i = document.getElementsByName("selected[]")[i];
        if( selected_i.checked == true) {
            participants += selected_i.id+";";
            dst_count++;
        }
    }
    alert(participants);
    if(dst_count == 0)
        alert("No paticipants selected.");
    else
        location.href = "./doodle.php?part="+participants;
}

//
// Filter the items in the fields
//
function filterResults(field) {

    var query = field.value;

    // split lowercase on white spaces
    var words = query.toLowerCase().split(" ");

    // loop over all lines
    var maintable = document.getElementById("maintable")
    var tbody     = maintable.getElementsByTagName("tbody");
    var entries   = tbody[0].children;
    var foundCnt  = 0;

    // Skip header(0) + selection row(length-1)
    for(i = 1; i < entries.length-1; i++) {

        // Firstname + LastName + Phonenumber + Mailaddress
        var content = entries[i].childNodes[0].childNodes[0].accept
        + " " + entries[i].childNodes[1].innerHTML
        + " " + entries[i].childNodes[2].innerHTML
        + " " + entries[i].childNodes[3].innerHTML
        + " " + entries[i].childNodes[4].innerHTML;

        // Don't be case sensitive
        content = content.toLowerCase();

        // check if all words are present
        var foundAll = true;
        for(j = 0; j < words.length; j++) {
            foundAll = foundAll && (content.search(words[j]) != -1);
        }

        // Keep selected entries
        foundAll = foundAll || entries[i].childNodes[0].childNodes[0].checked;

        // ^Hide entry
        if(foundAll) {
            last_url = entries[i].childNodes[5].childNodes[0].href;
            entries[i].style.display = "";
            if((foundCnt % 2) == 0) {
                entries[i].className = "odd";
            } else {
                entries[i].className = "even";
            }
            foundCnt++;
        } else {
            entries[i].style.display = "none";
        }
    }
    document.getElementById("search_count").innerHTML = foundCnt;

    // Auto-Forward if only one entry found
    if(foundCnt == 1 && false) {
        location = last_url;
    }
}