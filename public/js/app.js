$(document).ready(function() {

    let elem = $("ul").find("div").first();


    var loader = {

        img: $("#loader"),

        on: function () { loader.img.show() },

        off: function () { loader.img.hide() }
    };

    var forma = {

        inputs: ["fullname", "birthdate", "email", "message"],

        start: function () {
            loader.on();

            let fields = forma.inputs;

            fields.forEach(function(item, i, fields) {
                forma.fields[item].input.attr('disabled', true);
            });

        },

        stop: function () {
            loader.off();

            let fields = forma.inputs;

            fields.forEach(function(item, i, fields) {
                forma.fields[item].input.removeAttr('disabled', true);
            });
        },

        resetErr: function () {

            let fields = forma.inputs;

            fields.forEach(function(item, i, fields) {
                $(forma.fields[item].parrent).removeClass("err");
            });
        },

        setVal: function ( old ) {

            let fields = forma.inputs;

            for(key in old) {

                if($.inArray(key, fields) !== -1){
                    $(forma.fields[key].set(old[key]));
                };
            }
        },

        resetVal: function () {

            let fields = forma.inputs;

            fields.forEach(function(item, i, fields) {
                forma.fields[item].set('');
            });
        },



        setErrors: function ( errors ) {
            for(key in errors) {
                $(forma.fields[key].parrent).addClass("err");
            }
        },
        fields: {
            fullname: {

                input  : $("#fullname") ,
                parrent: $("#fullname").parent(),
                set    : setData,
            },
            birthdate: {

                input  : $("#birthdate") ,
                parrent: $("#birthdate").parent(),
                set    : setData,
            },
            email: {

                input  : $("#email") ,
                parrent: $("#email").parent(),
                set    : setData,
            },
            csrf: {
                input: $("#csrf") ,
                set  : setData,
            },
            message: {
                input  : $("#message") ,
                parrent: $("#message").parent(),
                set    : setData,
            }
        }

    }

    function setData( value ) {
        this.input.val(value);
    }

    $('[message]').on('submit', function (e) {
        e.preventDefault();

        var form = e.target;

        $.ajax({
            type: 'POST',
            url: '/',
            dataType: 'json',
            data: $(form).serialize(),
            beforeSend: forma.start,
            success: function (dat) {

                forma.fields.csrf.set(dat.data.CSRF);
                forma.resetErr();
                forma.resetVal();

                addPosts(dat.data.posts.data);
            },
            error: function (res) {

                let dat = res.responseJSON;

                forma.fields.csrf.set(dat.data.CSRF);
                forma.resetErr();
                forma.setErrors(dat.errors);
                forma.setVal(dat.old);

                addPosts(dat.data.posts.data);
            },
            complete: function () {
                forma.stop();
            }
        });
    });

    function createPost( dat ) {

        let name;

        if(dat.email) name = '<a href="' + dat.email + '">'+ dat.fullname +'</a>';
        else name = dat.fullname;

        let start = new Date(dat.date);

        let now = new Date();
        let ago = new Date((now - start));

        let h = '';
        let m = '';

        if(ago.getUTCHours()) h = ago.getUTCHours() +'h ';
        if(ago.getUTCMinutes()) m = ago.getUTCMinutes() +'m ';

        ago = h+m;

        let templ = '<li><span>' + dat.date +'</span>' + name + ' , ' + ago + '<br>'
           + dat.message +  '</li>';

        let message = $(templ);

        return message;
    }
    console.log(elem);

    function addPosts( data ) {

        elem.html('');

        for(key in data) {

            elem.append(createPost(data[key]))
        }
    }

})

