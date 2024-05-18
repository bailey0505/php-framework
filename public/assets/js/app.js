/**
 * Application JS file. ALL functions here should be universal
 * @author Bailey Rotellini <baileyrotellini1998@gmail.com>
 */



/**
 * Function for showing alert
 * Types of alerts: alert, success, warning, error, info/information
 * Position X: left, right, center
 * Position Y: top, bottom
 */
function ShowAlert(message, type, positionX, positionY, duration){
    if(!message)
        return false;

    if(!type)
        type = 'info';
    
    if(!positionX)  
        positionX = 'right';
    
    if(!positionY)
        positionY = 'top';
    
    if(!duration)
        duration = 5000;

    
    var ripple = true; 
    var dismissible = true;

    window.notyf.open({
        type,
        message,
        duration,
        ripple,
        dismissible,
        position: {
            x: positionX,
            y: positionY
        }
    });


}
