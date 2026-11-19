document.addEventListener("DOMContentLoaded", () => {

            const botones = document.querySelectorAll("header form.idiomas button");

            botones.forEach((boton) => {

                boton.addEventListener("click", () => {

                    botones.forEach((b) => b.classList.remove("activo"));
                    boton.classList.add("activo");
                    
                });

            });

        });