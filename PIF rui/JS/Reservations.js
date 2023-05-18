var reservation = {
    roomid: null,
    arr: []
}
// function that returns true if array has element
function countInArray(element, arr) {
    for (let i = 0; i < arr.length; i++) {
        if (arr[i] == element) {
            return true;
        }
    }
    return false
}
//end

//function that finds the smallest and the largest element in the arrays
function minmax(arr) {
    let min = 100;
    let max = -100;
    for (let i = 0; i < arr.length; i++) {
        if (arr[i] < min) {
            min = arr[i]
        }
        if (arr[i] > max) {
            max = arr[i]
        }
    }
    return [min, max]
}
// end

$(document).ready(() => {
    $(".room-details").bind("click", function () {

    })
    //Function to select time slots to reserve
    $(".rooms_container").on("click", ".time-slot-free", function () {
        let timeid = Number($(this).attr("timeid"))
        let roomid = $(this).parent().parent().parent().attr("roomid")
        if (reservation.arr.length == 0) {//Add first element to array
            reservation.roomid = roomid
            reservation.arr.push(timeid)
            $(this).addClass("mark-green")
        }
        else if (reservation.roomid == roomid && countInArray(timeid, reservation.arr) == false) {// Add element to array
            if (countInArray(timeid - 1, reservation.arr) == true || countInArray(timeid + 1, reservation.arr)) {
                reservation.arr.push(timeid)
                $(this).addClass("mark-green")
            }
        }
        else if (reservation.roomid == roomid && countInArray(timeid, reservation.arr) == true) { // Remove element from array
            let [min, max] = minmax(reservation.arr)
            if (timeid == min || timeid == max) {
                var index = reservation.arr.indexOf(timeid);
                reservation.arr.splice(index, 1);
                $(this).removeClass("mark-green")
            }
        }
    })
    //End


    //Request data about free rooms on the calendar change event
    $(".calendar").bind("change", function () {
        let date = $(this).val();
        $.ajax({
            url: "../PHP/rooms.php",
            type: "GET",
            dataType: "json",
            data: ({
                date: date
            }),
            success: function (allres) { // runs if request returned http code 200
                let message = allres.message
                if (message != "Success") { // check if search was successful
                    return
                }
                let res = allres.rooms

                $(".rooms_container").html("")
                // append rooms to the body
                res.map((val) => {
                    let room = `<div class="room" roomid="${val.number}">
                    <div class="room-general-info">
                        <p class="room-number">${val.number}</p>
                        <input type="button" value="Reserve" class="room-reserve-btn">
                    </div>
                    <div class="room-reservations-info">
                        <div class="room-reservations-container">
                            <div class="time-slot-free" timeid="1">
                                08:00 - 09:00
                            </div>
                            <div class="time-slot-free" timeid="2">
                                09:00 - 10:00
                            </div>
                            <div class="time-slot-free" timeid="3">
                                10:00 - 11:00
                            </div>
                            <div class="time-slot-free" timeid="4">
                                11:00 - 12:00
                            </div>
                            <div class="time-slot-free" timeid="5">
                                12:00 - 13:00
                            </div>
                            <div class="time-slot-free" timeid="6">
                                13:00 - 14:00
                            </div>
                            <div class="time-slot-free" timeid="7">
                                14:00 - 15:00
                            </div>
                            <div class="time-slot-free" timeid="8">
                                15:00 - 16:00
                            </div>
                            <div class="time-slot-free" timeid="9">
                                16:00 - 17:00
                            </div>
                        </div>
                    </div>
                    </div>`
                    $(".rooms_container").append(room)
                })
                //end
            }
        })
    })

    $(".rooms_container").on("click", ".room-reserve-btn", function () {
        let roomid = Number($(this).parent().parent().attr("roomid")) // get roomid of the parent div
        if (roomid != reservation.roomid || reservation.arr.length == 0) { // small client side input validation
            alert("Input error")
            return
        }
        $.ajax({ // reservation request
            url: "../PHP/reservation.php",
            type: "POST",
            dataType: "json",
            data: ({
                roomid: reservation.roomid,
                resarr: JSON.stringify(reservation.arr),
                date: $(".calendar").val(),
                purpose: "purposePlaceholder"
            }),
            success: function (res) {
                //check if room was reserved
                if (res.message == "reserved") {
                    alert("room was reserved, thank you")
                    reservation.arr = []//clear the reservation array
                    reservation.roomid = null //clear the roomid
                    $(".time-slot-free").removeClass("mark-green")//remove all green timeslots
                }
            }
        })
    })
})