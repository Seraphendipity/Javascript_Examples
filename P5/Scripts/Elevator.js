{ // C1_V1 -- 52s
    init: function(elevators, floors) {
        var elevator = elevators[0]; // Let's use the first elevator

        // Whenever the elevator is idle (has no more queued destinations) ...
        elevator.on("idle", function() {
            // let's go to all the floors (or did we forget one?)
            elevator.goToFloor(0);
            elevator.goToFloor(1); 
            elevator.goToFloor(2); 
        });
    },
    update: function(dt, elevators, floors) {
        // We normally don't need to do anything here
    }
}

{ // C1_V2 -- 55s
    init: function(elevators, floors) {
        var e = elevators[0]; // Let's use the first elevator
        var f = floors;
        // e.on("idle", function() {
        //     e.goToFloor(0);
        //     e.goToFloor(1); 
        //     e.goToFloor(2); 
        // });
        e.on("floor_button_pressed", function(floor) {
            e.goToFloor(floor);
        });
        f[0].on("up_button_pressed", function() {
            e.goToFloor(0);
        });
        f[1].on("up_button_pressed", function() {
            e.goToFloor(1);
        });
        f[1].on("down_button_pressed", function() {
            e.goToFloor(1);
        });
        f[2].on("down_button_pressed", function() {
            e.goToFloor(2);
        });

        // for(i=0; i < f.length; i++) {
        //     f[i].on("up_button_pressed:", function() {
        //         e.goToFloor(f[i]);
        //     });
        //     f[i].on("down_button_pressed:", function() {
        //         e.goToFloor(f[i]);
        //     });
        // }
    },
        update: function(dt, elevators, floors) {
            // We normally don't need to do anything here
        }
}

{ // C2_V3 -- 59s -- good framework for further optimisation
    init: function(elevators, floors) {
        var e = elevators[0]; // Let's use the first elevator
        var f = floors;

       e.on("floor_button_pressed", function(floor) {
           e.goToFloor(floor);
           console.log("Q+: " + floor + " e")
           console.log(e.destinationQueue);
       });

        //FLOORS - goes to floor they want
        f.forEach(function(fl) {
            var i = fl.floorNum();
            fl.on("up_button_pressed", function() {
                e.goToFloor(i);
                console.log("Q+: " + i + " fu");
            });
            fl.on("down_button_pressed", function() {
                e.goToFloor(i);
                console.log("Q+: " + i + " fd");
             });
        });
    }, update: function(dt, elevators, floors) {}
}

{ // C3_V4 -- 59s -- Elevator Algorithm: goes in same dir
    init: function(elevators, floors) {
        elevators.forEach(function(e) {

        var floorMin = 0; var floorMax = floors.length-1;
        e.on("floor_button_pressed", function(floor) {
           e.goToFloor(floor);
           console.log("Q+: " + floor + " e")
           console.log(e.destinationQueue);
        });
        e.on("passing_floor", function(floorNum, direction) {
           if(direction == e.destinationDirection || 
                e.destinationDirection == "stopped" ||
                floorNum == floorMax || floorNum == floorMin) {
                goToFloor(floorNum, true); //This stop is on the way, stop
            }
        });

        //FLOORS - goes to floor they want
        floors.forEach(function(fl) {
            var i = fl.floorNum();
            fl.on("up_button_pressed", function() {
                e.goToFloor(i);
                console.log("Q+: " + i + " fu");
            });
            fl.on("down_button_pressed", function() {
                e.goToFloor(i);
                console.log("Q+: " + i + " fd");
             });

        });
    });
    }, update: function(dt, elevators, floors) {}
}



{ // 52s, 59s, 56s, 57s
    init: function(elevators, floors) {
        var i = 0;
        elevators.forEach(function(elev) {
            elev.goToFloor(floors.length/elevators.length * i);i++;
            floors.forEach(function(fl) {
                elev.on("idle", function() {
                    elev.goToFloor(fl.floorNum());
                });

            });
        });
    },
    update: function(dt, elevators, floors) {
        // We normally don't need to do anything here
    }
}

// Elevators: Modern elevators are strange and complex entities. The ancient electric winch and "maximum-capacity-eight-persons" jobs bear as much relation to a Sirius Cybernetics Corporation Happy Vertical People Transporter as a packet of mixed nuts does to the entire west wing of the Sirian State Mental Hospital.

// This is because they operate on the curious principle of "defocused temporal perception." In other words they have the capacity to see dimly into the immediate future, which enables the elevator to be on the right floor to pick you up even before you knew you wanted it, thus eliminating all the tedious chatting, relaxing and making friends that people were previously forced to do while waiting for elevators.

// Not unnaturally, many elevators imbued with intelligence and precognition became terribly frustrated with the mindless business of going up and down, up and down, experimented briefly with the notion of going sideways, as a sort of existential protest demanded participation in the decision-making process and finally took to squatting in basements sulking.

// An impoverished hitchhiker visiting any planets in the Sirius star system these days can pick up easy money working as a counselor for neurotic elevators.