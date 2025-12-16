const snowflakeCount = 50; // počet vločiek

for(let i = 0; i < snowflakeCount; i++) {
    createSnowflake();
}

function createSnowflake() {
    const snowflake = document.createElement('div');
    snowflake.classList.add('snowflake');

    // veľkosť vločky
    const size = Math.random() * 5 + 2;
    snowflake.style.width = `${size}px`;
    snowflake.style.height = `${size}px`;

    // počiatočná pozícia
    snowflake.style.left = `${Math.random() * window.innerWidth}px`;

    document.body.appendChild(snowflake);

    // animácia pohybu
    let posY = -10;
    const speed = Math.random() * 1 + 0.5;
    const drift = Math.random() * 0.5 - 0.25; // jemný bočný pohyb

    function fall() {
        posY += speed;
        const currentX = parseFloat(snowflake.style.left);
        snowflake.style.top = `${posY}px`;
        snowflake.style.left = `${currentX + drift}px`;

        if(posY < window.innerHeight) {
            requestAnimationFrame(fall);
        } else {
            // po dopade vločka zmizne a znovu sa vytvorí
            snowflake.remove();
            createSnowflake();
        }
    }
    fall();
}
