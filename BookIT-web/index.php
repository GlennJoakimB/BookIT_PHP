<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style/style.css">
    <title>BookIT - Hovedside</title>
</head>
<body>
    <?php
        // Session_start gjør det mulig å sjekke verdier og funksjoner relatert til sessions.
        session_start();
        
        // Sjekk om session eksisterer.
        if(!isset($_SESSION)) {
            //Redirect to login mayhaps
            header("Location: ./Pages/login.php");
            exit();
        } else {
            //redirect to Main
            header("Location: ./Shared/Main.php");
            exit();
        }
    ?>
    <p>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae perferendis eos fugit distinctio facilis reiciendis minus quae iusto consectetur quod ipsum officia dolores, itaque enim accusantium. Accusamus, eum dicta? Illo atque aliquam quos aspernatur delectus, tempore minus nesciunt sapiente iste eveniet magnam nemo fugiat ullam labore quas officia exercitationem doloremque inventore laboriosam, molestias obcaecati consequatur amet placeat beatae! Sit nam exercitationem mollitia dolorem repellat enim, blanditiis doloribus voluptates facere ratione odio accusantium porro qui dicta harum sunt quod nisi ipsa? Modi id consectetur officia? Neque placeat veniam numquam error saepe ab tempore distinctio velit, repudiandae sed eos. Esse dolorem hic voluptates sunt libero rerum repellat quos, officia dignissimos inventore vel. Nobis excepturi doloribus minima explicabo necessitatibus recusandae? Officiis hic ab suscipit et repellendus optio, officia, illum modi voluptatum maxime sed velit quae architecto corporis non ratione exercitationem cum aliquam. Unde eos, numquam ex molestias odio soluta a ipsam maiores dolor.
    </p>
    <p>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae perferendis eos fugit distinctio facilis reiciendis minus quae iusto consectetur quod ipsum officia dolores, itaque enim accusantium. Accusamus, eum dicta? Illo atque aliquam quos aspernatur delectus, tempore minus nesciunt sapiente iste eveniet magnam nemo fugiat ullam labore quas officia exercitationem doloremque inventore laboriosam, molestias obcaecati consequatur amet placeat beatae! Sit nam exercitationem mollitia dolorem repellat enim, blanditiis doloribus voluptates facere ratione odio accusantium porro qui dicta harum sunt quod nisi ipsa? Modi id consectetur officia? Neque placeat veniam numquam error saepe ab tempore distinctio velit, repudiandae sed eos. Esse dolorem hic voluptates sunt libero rerum repellat quos, officia dignissimos inventore vel. Nobis excepturi doloribus minima explicabo necessitatibus recusandae? Officiis hic ab suscipit et repellendus optio, officia, illum modi voluptatum maxime sed velit quae architecto corporis non ratione exercitationem cum aliquam. Unde eos, numquam ex molestias odio soluta a ipsam maiores dolor.
    </p>
</body>
</html>