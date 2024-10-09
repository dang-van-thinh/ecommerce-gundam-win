$(document).ready(function () {
    let startDate = $('#start_date');
    let endDate = $('#end_date');
    let room = $('#room_id');
    let dayOfClass = $('#day_of_week_id');
    var dataSessions = null;

    // event
    // [startDate, endDate, room, dayOfClass].forEach(function (element) {
    //     $(element).on('change', function () {
    //         if (startDate.val() != '' && endDate.val() != '' && dayOfClass.val() != '') {
    //             // console.log(dayOfClass.val());
    //             let url = $(this).parents('#formHandler').data('url');
    //             if (dataSessions == null) {

    //                 console.log('dung');
    //                 console.log($(this).parents('#formHandler').data('urlsession'));
    //                 dataSessions = ajaxGetAllSession($(this).parents('#formHandler').data('urlsession'));
    //             }
    //             console.log("danh sahch session " + dataSessions);

    //             let data = {
    //                 'startDate': startDate.val(),
    //                 'endDate': endDate.val(),
    //                 'roomId': room.val(),
    //                 'dayOfWeek': dayOfClass.val()
    //             }
    //             console.log(data);
    //             handlerDataCheck(url, data);
    //         }
    //     });
    // });


    // select2 cho ngay học trong tuần
    $(document).ready(function () {
        $('#day_of_week_id').select2();
    });

});

// function showSessionOption(sessions = []) {
//     sessions.forEach(element => {

//     });
// }

// // phai su dung dong bo , vi ajax nay no bat dong bo
// async function ajaxGetAllSession(url) {
//     try {
//         const data = await $.ajax({
//             type: "get",
//             url: url,
//             dataType: "json"
//         });
//         return data;
//     } catch (error) {
//         console.warn("Lỗi do gọi api ajaxGetAllSession");
//         throw error
//     }
// }


// // lay du lieu cac ca hoc cua lop tu ngay bat dau -> ket thuc lop hoc
// function handlerDataCheck(url, data) {
//     $.ajax({
//         type: "get",
//         url: url,
//         data: data,
//         dataType: "json",
//         success: function (response) {
//             console.log(response.session);
//             sessionViewData(response.session)
//         }
//     });
// }
// function sessionViewData(sessions = []) {
//     let selectSession = $(".opt-session");
//     if (sessions.length > 0) {
//         console.log(selectSession.val());;
//         sessions.forEach(session => {
//             selectSession.each(function () {
//                 // console.log($(this).val());
//                 if (session.id == $(this).val()) {
//                     console.log("đúng");
//                     $(this).attr('hidden', true)
//                 }
//             })
//         });
//     } else {
//         selectSession.each(function () {
//             $(this).attr('hidden', false)
//         });
//     }

// }