var cardsVersion = '1.0.0';
console.log('Gift Cards Version: ' + cardsVersion );
function content_finished_loading(iframe){
    console.log('content_finished_loading' + iframe.id);
}

window.addEventListener("message", receiveMessage, false);

function receiveMessage(event)
{
    if (event.origin !== "https://gc.nantucketislandresorts.com/"){

        console.log('Received Event: ',  event);

        $('#gc-frame').height(parseInt(event.data));

    }
}