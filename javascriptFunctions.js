function changeBackground(id)
{
    //alert("id : " + id);
    switch (id)
    {
        case 'starters':  
        document.getElementById("starters").style.backgroundColor = '#cc3366';
        document.getElementById("mainCourse").style.backgroundColor = '#4bb2e1';
        document.getElementById("desserts").style.backgroundColor = '#4bb2e1';

        document.body.style.backgroundImage = "url('static/images/startersCollage.jpeg')";
        document.getElementById('menu').src = 'fetchStarters.php';
        break;

        case 'mainCourse':
        document.getElementById("starters").style.backgroundColor = '#4bb2e1';
        document.getElementById("mainCourse").style.backgroundColor = '#cc3366';
        document.getElementById("desserts").style.backgroundColor = '#4bb2e1';
        document.body.style.backgroundImage = "url('static/images/mainCourseCollage.jpg')";
        document.getElementById('menu').src = 'fetchMainCourses.php';
        break;

        case 'desserts':
        document.getElementById("starters").style.backgroundColor = '#4bb2e1';
        document.getElementById("mainCourse").style.backgroundColor = '#4bb2e1';
        document.getElementById("desserts").style.backgroundColor = '#cc3366';
        document.body.style.backgroundImage = "url('static/images/dessertsCollage.jpg')";
        document.getElementById('menu').src = 'fetchDesserts.php';
        break;
    }
};

/**
 * Currently not using for anything!
 */
function ChangeTopMostBackground()
{
    var ancestor = null;

    if (window.top)
        ancestor = window.top;
    else
        var ancestor = window;

    while (ancestor.parent)
        ancestor = ancestor.parent;

    ancestor.document.body.style.backgroundImage = "url('loginBackground.png')";
}

function incrementValue(dishId)
{
    var value = parseInt(document.getElementById(dishId).value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById(dishId).value = value;
}

function decrementValue(dishId)
{
    var value = parseInt(document.getElementById(dishId).value, 10);
    value = isNaN(value) ? 0 : value;
    
    if (value > 0)
    {
        value--;
        document.getElementById(dishId).value = value;
    }
}
