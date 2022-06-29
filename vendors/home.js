$(function() {
    
    $('.modal').modal();
    
    $('.delete-contact').click(function() {
        var id = $(this).data('id');
        $("#deleteModalAgreeButton").attr('href',`delete.php?id=${id}`);
        console.log("You Clicked Delete Of id =" ,id );
        
    
    });
    function getQueryStrings() {
        // let url = window.location.href;
        // let indexOfQuesMark = url.indexOf('?);
        // let queryString = url.slice(indexOfQuesMark+1);
        // let queryparams = querySplit.split('&);
        let queryParams = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        let vars = [];
        queryParams.forEach(param => {
            let pair = param.split('=');
            let key = pair[0];
            let value = pair[1];
            vars[key] = value;
    
        });
        return vars;
    }
    
    let query = getQueryStrings();
    let operation = query['op'];
    let status = query['status'];
    if(operation === 'add' && status ==='success'){
        M.toast({
            html: 'Contact added sucessfully!',
            classes: 'green darken-1'
        });
    
    }  else if(operation === 'delete' && status==='success') {
        M.toast({
            html: 'Contact deleted sucessfully!',
            classes: 'green darken-1'
        });
    }
    
    })