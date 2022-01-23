let PokemonImages = ["Pikachu.png", "Charmeleon.png", "Caterpie.png", "Shiny.png", "Lugia.png", "Shiggy.png", "Ghost.png", "Gengar.png", "Greninja.png", "Onix.png", "Toxiped.png", "Bulbasaur.png", "gyarados.png", "Pikachu.png", "Charmeleon.png", "Caterpie.png", "Shiny.png", "Lugia.png", "Shiggy.png", "Ghost.png", "Gengar.png", "Greninja.png", "Onix.png", "Toxiped.png", "Bulbasaur.png", "gyarados.png"]

let ShuffledPokemonImages = [];

let arrayOfCardIds = [];

let firstCardRevealed = 0;

let CardRevealed = 0;

let lifes = 30;

//let mode = hard;

/*function Easymode() {
    mode = easy;
    document.getElementById("buttonmode").innerHTML = "Hard Mode";
    Start();
}

function Hardmode() {
    mode = hard;
    document.getElementById("buttonmode").innerHTML = "Easy Mode";
    Start();
}*/

function Start() {

    document.getElementById("lifesId").innerHTML = "Lifes left: " + lifes;

    //if (mode == hard) {
        for (; PokemonImages.length > 0;) {
            let randomPokemonImage = Math.floor(Math.random() * PokemonImages.length);
            ShuffledPokemonImages.push(PokemonImages[randomPokemonImage])
            PokemonImages.splice(randomPokemonImage, 1)

        }
        PokemonImages = ShuffledPokemonImages;
    //}


    for (let i = 0; i < PokemonImages.length; i++) {
        let newImage = document.createElement("img");
        newImage.src = "CardBack.png";
        newImage.id = "CardNo" + i;
        arrayOfCardIds.push(newImage.id);
        newImage.classList.add("oneCard");
        document.getElementById("myGame").append(newImage);
        newImage.addEventListener("click", function () { cardClicked(newImage.id, i); });  //Q try to change this
    }
}

function cardClicked(idOfClickedCard, PokemonIndex) {


    if (idOfClickedCard != firstCardRevealed && CardRevealed != 2) {
        document.getElementById(idOfClickedCard).src = PokemonImages[PokemonIndex];
        CardRevealed++;
        if (CardRevealed == 1) firstCardRevealed = idOfClickedCard;

        var cardClickedAudio = new Audio('Pokemon_(A_Button).mp3');
        cardClickedAudio.play();

        if (CardRevealed == 2) {
            let imageNameOffFirstCard = document.getElementById(firstCardRevealed).src;
            let imagesNameOffSecondCard = document.getElementById(idOfClickedCard).src;
            if (imageNameOffFirstCard == imagesNameOffSecondCard) {
                for (let i = 0; i < arrayOfCardIds.length; i++) {
                    if (arrayOfCardIds[i] == firstCardRevealed) {
                        arrayOfCardIds.splice(i, 1)
                        i--;
                    }

                    if (arrayOfCardIds[i] == idOfClickedCard) {
                        arrayOfCardIds.splice(i, 1)
                        i--;
                    }
                }


                lifes++;
            }


            lifes--;
            document.getElementById("lifesId").innerHTML = "Lifes left: " + lifes;

            setTimeout(function () {
                putAllImageBack();   //Q try to change this
            }, 1500);
        }
    }

}

function putAllImageBack() {

    if (arrayOfCardIds.length == 0) {
        window.location.href = 'Win.html';
    }

    if (lifes == 0) {
        window.location.href = 'GameOver.html';
    }

    for (CardIds of arrayOfCardIds) {
        document.getElementById(CardIds).src = "CardBack.png";
        firstCardRevealed = 0;
        CardRevealed = 0;
    }
}

