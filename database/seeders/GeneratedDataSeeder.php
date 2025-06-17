<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Destino;
use App\Models\Diario;
use App\Models\Comentario;
use App\Models\Friendship;
use App\Models\DiarioImagen;
use App\Models\DestinoImagen;

class GeneratedDataSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id' => 1,
            'uuid' => 'cfd6a9bd-d13c-4174-841b-789ae18a0eb5',
            'name' => 'Ruben Díez',
            'email' => 'lethal@gmail.com',
            'password' => '$2y$12$hj1JGcdhpK76KUkuLXvfIOcq4LqTZor5N5jfGyLurmOpXYZBnPB7a',
            'bio' => 'Soy documentalista y reconocido Youtuber internacional. He realizado expediciones por todo el planeta documentando todo tipo de culturas y conflictos.',
            'profile_image' => 'profile_images/yaESLh7kRvWKdvMqpZCL585X9nglBI4HIW3w1mUf.png',
        ]);
        User::create([
            'id' => 2,
            'uuid' => 'b3069a0e-93b9-4d09-ad89-2225a49a46ae',
            'name' => 'Lucia Madrid',
            'email' => 'lucy33@gmail.com',
            'password' => '$2y$12$TYGWDNpa7tSC797ob1lDLucL0HdPDiXCyrXFWQKztOYbf.fGeN93a',
            'bio' => '🖊 Periodista de viajes
🌍 Recorriendo el mapa para intentar (des)aprender
🎙 Divulgación cultural con enfoque de género
🐒 Defensa animal',
            'profile_image' => 'profile_images/q6LHONEauLJRSHxRWB8neWqSh0S98frQw8u5DDb1.png',
        ]);
        User::create([
            'id' => 3,
            'uuid' => 'c8d00db8-499c-459f-8ee3-5899b2cdbf69',
            'name' => 'Joan Riera',
            'email' => 'joan22@gmail.com',
            'password' => '$2y$12$9vzV7Mezsf.TGdQA9FCG3eZ3H.GrlyQBvilen0vR8zHjreVJ2t4DO',
            'bio' => 'Soy licenciado en Antropología y Sociología por la universidad de Richmond. Especializado en religiones animistas y procesos de recuperación cultural entre sociedades tribales',
            'profile_image' => 'profile_images/7D4HTpzUg0sMevAgiZVKrPzFBwBAgrEldlPKydvS.png',
        ]);
        User::create([
            'id' => 4,
            'uuid' => '8527b604-3ffa-4b48-bd7d-9f07922dc42d',
            'name' => 'Amarna Miller',
            'email' => 'amarna@gmail.com',
            'password' => '$2y$12$Fvmp7GnTTX90s8lTDbk7JeiNSriMyq.S4bNkSXisqtGyEgIEaQORG',
            'bio' => 'Estudié Bellas Artes y Antropología, y adoro la fotografía analógica, hacer cuadernos de viaje y toda la fase de investigación previa a las expediciones. Estoy enamorada del mundo y de la vida, y no hay cosa que me haga más feliz que poder compartir esa pasión con la gente que me rodea.',
            'profile_image' => 'profile_images/3tZPRxtktQFgnfWZ3Nsr0wrnFq2D1q3VU3zVkS3s.png',
        ]);
        User::create([
            'id' => 5,
            'uuid' => 'f8a1ec0f-9d87-42f1-8a48-03fc72ee245c',
            'name' => 'Aníbal Bueno',
            'email' => 'anibal43@gmail.com',
            'password' => '$2y$12$8gkeLk3tt696cZ8rbI50wuv3mwknMDSjdTWWxEQRAmxASkay0bWHe',
            'bio' => '📸 Documento culturas del mundo
⛺ Organizo expediciones
🗺️ Viaja conmigo desde @lastplacestravel
Mis libros, cursos y vídeos 👇
anibalbueno.photo/enlaces',
            'profile_image' => 'profile_images/DUds2O4W0AtRNbxnzTuj2MP1yzANpjU1HCrD74MP.png',
        ]);
        User::create([
            'id' => 6,
            'uuid' => '777362fa-2329-4aa9-8b53-92e40e631366',
            'name' => 'Demente con Mochila',
            'email' => 'francaLevin@gmail.com',
            'password' => '$2y$12$A.brhPJw4hoZDVi2Gb5qw.uyKx0lb2H.vqZa9s94UMQy7bxIaYLV.',
            'bio' => 'Viajo, escribo, fotografío
💁🏽‍♀️ Feminista y un poco loca
🔥 Atravesando África
📍 Guinea Bissau 🇬🇼
👇🏽YouTube, blog, descuentos y más!
linktr.ee/dementeconmochila',
            'profile_image' => 'profile_images/tDYphilFslAi2SwUjsSWAeHVRUheSS5yA7fEYTID.png',
        ]);
        Destino::create(['id' => 1, 'nombre_destino' => 'Conviviendo con los nenets', /*... otros campos ...*/ ]);
        Destino::create(['id' => 2, 'nombre_destino' => 'Cazando con los nenets', /*... otros campos ...*/ ]);
        Destino::create(['id' => 3, 'nombre_destino' => 'Kinshasa, la capital del caos', /*... otros campos ...*/ ]);
        Destino::create(['id' => 4, 'nombre_destino' => 'El Río Congo, la arteria de la selva', /*... otros campos ...*/ ]);
        Destino::create(['id' => 5, 'nombre_destino' => 'El pueblo Bakongo y sus cuevas sagradas', /*... otros campos ...*/ ]);
        Destino::create(['id' => 6, 'nombre_destino' => 'La “secta” Tata Gonda', /*... otros campos ...*/ ]);
        Destino::create(['id' => 7, 'nombre_destino' => 'Los luchadores vudú, magia negra y wrestling en África', /*... otros campos ...*/ ]);
        Destino::create(['id' => 8, 'nombre_destino' => 'Los últimos cazadores de CABEZAS HUMANAS', /*... otros campos ...*/ ]);
        Destino::create(['id' => 9, 'nombre_destino' => 'Las Mujeres Apatani: una belleza diferente', /*... otros campos ...*/ ]);
        Destino::create(['id' => 10, 'nombre_destino' => 'SIRIA EN LA ACTUALIDAD ¿Por qué llevan 10 años en CONFLICTO?', /*... otros campos ...*/ ]);
        Destino::create(['id' => 11, 'nombre_destino' => 'El origen de los Gitanos: Khana Badosh', /*... otros campos ...*/ ]);
        Destino::create(['id' => 12, 'nombre_destino' => 'Pigmeos Baka: la tribu MÁS PEQUEÑA del mundo', /*... otros campos ...*/ ]);
        Destino::create(['id' => 13, 'nombre_destino' => 'BUSCANDO LA TRIBU PERDIDA: LOS KOMA', /*... otros campos ...*/ ]);
        Destino::create(['id' => 14, 'nombre_destino' => 'Los DOGONES: peligro en el corazón de África', /*... otros campos ...*/ ]);
        Destino::create(['id' => 15, 'nombre_destino' => 'El territorio Mundari, un mundo de humo y vacas en Sudán del Sur', /*... otros campos ...*/ ]);
        Destino::create(['id' => 16, 'nombre_destino' => 'Explorando las joyitas medievales de Rumania', /*... otros campos ...*/ ]);
        Destino::create(['id' => 17, 'nombre_destino' => 'Viajando Sola por la Ruta Más Peligrosa de Rumania', /*... otros campos ...*/ ]);
        Destino::create(['id' => 18, 'nombre_destino' => 'Los últimos nómadas de SIBERIA', /*... otros campos ...*/ ]);
        Destino::create(['id' => 19, 'nombre_destino' => 'Visitando Buenos Aires: Casa Roja de AMMAR + las Cataratas del Iguazú', /*... otros campos ...*/ ]);
        Destino::create(['id' => 20, 'nombre_destino' => 'Visitando Ushuaia: Parque Nacional Tierra del Fuego y Glaciar Martial', /*... otros campos ...*/ ]);
        Diario::create([ 
           'id' => 1,
           'user_id' => 1,
           'titulo' => 'Hijos de la Tundra',
           'contenido' => 'La experiencia es una inmersión total en una forma de vida ancestral, marcada por una supervivencia extrema y una dependencia absoluta del reno. Este animal lo es todo: transporte, alimento, vestimenta y refugio. El relato se centra en el día a día, enfrentando un frío implacable y ventiscas que pueden desorientar a cualquiera en la inmensidad blanca de la tundra siberiana.

La vida es un ciclo de migración constante, siguiendo a los renos en busca de pastos. Se aprende a pescar en el hielo, rompiendo gruesas capas para echar las redes, y a consumir alimentos como el pescado crudo, una necesidad para obtener nutrientes en este entorno. La experiencia muestra la dureza de la vida, donde una tormenta o un accidente pueden ser fatales, pero también la increíble resiliencia y el profundo conocimiento que tienen los Nenets de su entorno. Es un testimonio de cómo una cultura ha logrado vivir en armonía con uno de los climas más hostiles del planeta, manteniendo vivas sus tradiciones y su conexión espiritual con la tierra y los animales.',
        ]);
        Diario::create([ 
           'id' => 2,
           'user_id' => 1,
           'titulo' => 'Stories from Congo',
           'contenido' => 'El Congo te recibe con un golpe de calor y una bofetada de realidad. Aterrizar en Kinshasa no es llegar a una ciudad, es sumergirse en un caos vibrante, un organismo vivo de casi 20 millones de almas que luchan, ríen y sobreviven cada día. La primera impresión es abrumadora: el ruido incesante, el tráfico que parece regirse por leyes propias y una energía humana desbordante. Pero más allá del bullicio, te encuentras con la mirada de la gente, una mezcla de curiosidad, dureza y una hospitalidad que te desarma.
El verdadero viaje comenzó al dejar atrás el asfalto. Nos adentramos en la selva, siguiendo el curso del río Congo, la gran arteria que da y quita la vida en este país. Aquí, el tiempo se mide de otra forma. Los días están marcados por la humedad pegajosa, el sonido de los insectos y la tensión constante de no saber qué te espera. Navegar por esas aguas oscuras, viendo aldeas remotas aparecer entre la vegetación, es entender la verdadera dimensión del país y su desconexión.

La experiencia culminó al convivir con los pigmeos, los guardianes de una selva que está desapareciendo. Ver su forma de vida, su increíble habilidad para cazar con redes y su profunda conexión con un entorno que los está expulsando, te cambia por dentro. Fue un privilegio, pero también un recordatorio doloroso de su lucha por la supervivencia contra la deforestación y la marginación. El Congo es un lugar que te desafía en todos los niveles; es duro, a veces peligroso, pero su belleza cruda y la fuerza de su gente te dejan una marca imborrable.',
        ]);
        Diario::create([ 
           'id' => 3,
           'user_id' => 1,
           'titulo' => 'Visitando Asia',
           'contenido' => 'Este viaje por Asia no fue una búsqueda de paisajes, sino de rostros y de historias grabadas en la piel. Desde las colinas remotas de Nagaland, donde conocí a los últimos guerreros de una era olvidada, hasta los valles de Arunachal Pradesh, donde la belleza se medía con otros cánones, cada parada fue una lección de identidad. Me sumergí en culturas que luchan por no desaparecer, cuyas tradiciones, a veces brutales, a veces de una belleza incomprensible, definen quiénes son.

Luego, el viaje dio un giro radical. De la historia ancestral pasé a la cruda realidad de la historia moderna en Siria, caminando por calles que son cicatrices vivas de una guerra que no termina. Y de ahí, a Pakistán y la India, siguiendo el rastro de pueblos nómadas: los Mohana, que nacen y mueren en el agua, y los Khana Badosh, cuyas danzas y cantos son el eco lejano del origen de los gitanos.

Este no fue un viaje fácil. Fue un recorrido por los márgenes, por las historias que no suelen contarse. Fue un recordatorio de que, a pesar de la globalización, el mundo sigue lleno de universos paralelos, cada uno con sus propias reglas, su propia belleza y su propia lucha por existir.',
        ]);
        Diario::create([ 
           'id' => 4,
           'user_id' => 5,
           'titulo' => 'Tribus Africanas',
           'contenido' => 'África te pone a prueba. Este no fue un viaje, fue una sucesión de expediciones a mundos que operan bajo lógicas completamente distintas a la nuestra. Desde las selvas húmedas de Camerún, donde el sonido de los cantos de los pigmeos Baka te conecta con el alma del bosque, hasta las montañas remotas donde los Koma viven una vida casi suspendida en el tiempo, cada paso fue un ejercicio de humildad.

El viaje me llevó al Valle del Omo en Etiopía, un lugar de una belleza brutal, donde la violencia ritual del Donga de los Surma y el orgullo de sus tradiciones te confrontan directamente. Luego, al corazón de Malí, para admirar la increíble cosmología de los Dogones, aferrados a sus acantilados mientras el peligro de la yihad se cierne sobre ellos.

Finalmente, Sudán del Sur, el país más joven y uno de los más convulsos del mundo. Allí, entre los Toposa, vi cómo un AK-47 es tan común como un bastón de pastor, una herramienta de supervivencia en una tierra de conflictos por el ganado. Y la culminación fue con los Mundari, en un campamento que parece un paisaje de otro planeta, envuelto en el humo de las hogueras y definido por una devoción casi sagrada a sus impresionantes vacas. Este viaje fue un recordatorio constante de que, para entender el mundo, tienes que estar dispuesto a adentrarte en sus rincones más complejos y, a menudo, más peligrosos.',
        ]);
        Diario::create([ 
           'id' => 5,
           'user_id' => 6,
           'titulo' => 'Europa',
           'contenido' => 'Rumania fue un pulso constante entre la maravilla y la vulnerabilidad. Empecé buscando la postal medieval de Transilvania, con sus iglesias fortificadas y sus pueblos de colores congelados en el tiempo, pero me encontré con algo mucho más profundo. Me encontré con el eco de los osos en cada sendero y la calidez inesperada en la mirada de la gente que me abría la puerta de su coche.

Este viaje fue un ejercicio de confianza. Confiar en mi instinto al levantar el pulgar en una carretera solitaria, confiando en que la próxima persona sería de fiar. Confiar en que las murallas de Sighișoara no solo me contaban historias de príncipes y dragones, sino que también me estaban protegiendo',
        ]);
        Diario::create([ 
           'id' => 6,
           'user_id' => 4,
           'titulo' => 'Viaje a Siberia',
           'contenido' => 'Siberia te rompe los esquemas. Llegar allí es despojarse de todo lo que crees saber sobre el confort, la comunidad y la propia vida. La experiencia con los Nenets en la península de Yamal fue menos un viaje y más una inmersión en un universo paralelo, un mundo gobernado por el frío, el viento y el ritmo ancestral de los renos.

Los días transcurrían en una quietud blanca, casi hipnótica. El frío no es solo una temperatura, es una entidad que lo impregna todo, desde el crujido de la nieve bajo las botas hasta el vapor de tu propio aliento. Sin embargo, dentro del chum (su tienda de piel de reno), alrededor del fuego, se encuentra una calidez que va más allá de lo físico. Es el calor de la familia, de los gestos silenciosos, de una comunidad donde cada persona es un pilar indispensable para la supervivencia del resto.',
        ]);
        Diario::create([ 
           'id' => 7,
           'user_id' => 4,
           'titulo' => 'Viajando por Argentina',
           'contenido' => 'Argentina fue un viaje de extremos, una exploración de la escala monumental de la naturaleza y de la complejidad humana. Comencé en la vibrante y contradictoria Buenos Aires, una ciudad con alma europea y corazón latino, donde las calles susurran historias de tango, política y pasión. Allí, más allá de los circuitos turísticos, busqué entender realidades sociales complejas, como la de las trabajadoras sexuales de AMMAR. Luego, un salto a la selva subtropical para sentir la fuerza atronadora de las cataratas del Iguazú, una experiencia que te hace sentir diminuta ante el poder del agua.

El verdadero viaje hacia el interior, sin embargo, fue hacia el sur, hacia la Patagonia. Pisar el Perito Moreno y escuchar el estruendo del hielo al romperse es como presenciar el pulso del planeta en tiempo real. Es una belleza sobrecogedora que te recuerda la fragilidad de estos gigantes de hielo. La ruta me llevó a El Chaltén, la capital del trekking, y finalmente a Ushuaia, la ciudad en el \"Fin del Mundo\". Estar allí, rodeada de picos nevados y canales helados, te da una sensación de aislamiento y de haber llegado a uno de los últimos confines de la Tierra. Fue un viaje que me llenó los ojos de maravillas naturales y el corazón de preguntas sobre la sociedad, el feminismo y nuestro impacto en el planeta.',
        ]);
        Diario::create([ 
           'id' => 8,
           'user_id' => 1,
           'titulo' => 'Ébano',
           'contenido' => '',
        ]);
        DiarioImagen::create(['id' => 1, 'diario_id' => 1, 'url_imagen' => 'imagenes/diarios/gwX8cPzut357i3xSUSyD7YHms9wLU0kfPW7dKnZh.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 2, 'diario_id' => 1, 'url_imagen' => 'imagenes/diarios/TvBc3hP13uD7vHzdiiDoCbxcAVK793N4PcOQNWDH.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 3, 'diario_id' => 1, 'url_imagen' => 'imagenes/diarios/g2OIBOco2U74YuE0lY3sh1r0GcYlYGe2ryeCQ5Ol.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 4, 'diario_id' => 1, 'url_imagen' => 'imagenes/diarios/F5gmz9UIXwsdQNrPTnvxyooh2yycdpmHHuOKuxdV.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 5, 'diario_id' => 1, 'url_imagen' => 'imagenes/diarios/an8wEBL15LwY69ggwX11G3ABeAlOndjb5KKog37p.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 6, 'diario_id' => 1, 'url_imagen' => 'imagenes/diarios/prg1HNkGdXtiNVuDAjK1XtpDSjnD173QgiJgLnL5.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 8, 'diario_id' => 2, 'url_imagen' => 'imagenes/diarios/a9tyVuvq1W2mzx6agUrDrQI716Qa4XJH7rRYRSYX.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 9, 'diario_id' => 2, 'url_imagen' => 'imagenes/diarios/Q9mIQEfycejNMzvwkpDnhaixoTAsLMAyP6Ch89Ja.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 10, 'diario_id' => 2, 'url_imagen' => 'imagenes/diarios/I9IHRvYa4dY4x8GVnR5yp5XQ3lY7Gx660AklpiNu.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 11, 'diario_id' => 2, 'url_imagen' => 'imagenes/diarios/SwzJkdGyUBI8niUCNMWutM3CjbOhHLEMyjU6NLoL.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 12, 'diario_id' => 2, 'url_imagen' => 'imagenes/diarios/SkRifLRvWRceBUqy86CTpmJqIMxLNoTqWFeX9D6n.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 13, 'diario_id' => 3, 'url_imagen' => 'imagenes/diarios/default.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 15, 'diario_id' => 5, 'url_imagen' => 'imagenes/diarios/default.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 16, 'diario_id' => 6, 'url_imagen' => 'imagenes/diarios/default.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 17, 'diario_id' => 7, 'url_imagen' => 'imagenes/diarios/default.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 18, 'diario_id' => 4, 'url_imagen' => 'imagenes/diarios/mazTDSM8sVVksCXg78Pjs5NkSf8ZQFtjVYxXT1xZ.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 19, 'diario_id' => 4, 'url_imagen' => 'imagenes/diarios/GV4Wb1RHGdLHyLrL4LL51f8xKhIPXkFwD2cuaS9Z.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 20, 'diario_id' => 4, 'url_imagen' => 'imagenes/diarios/huiMbvSgj6t0vECdMJqKC1ztxhLJ3wwhih3Azz5a.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 21, 'diario_id' => 4, 'url_imagen' => 'imagenes/diarios/94khsMLJkMuJASDDcMMkqtBhy4UiuuB2aVf03jUA.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 22, 'diario_id' => 5, 'url_imagen' => 'imagenes/diarios/eEA8M5DVQJgHV0Fip8viyEehL5ufeiTiPKhwy3h9.png', /*... otros campos ...*/]);
        DiarioImagen::create(['id' => 23, 'diario_id' => 8, 'url_imagen' => 'imagenes/diarios/default.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 2, 'destino_id' => 2, 'url_imagen' => 'destino_imagenes/svodpzJ4NOdwJBFMU5CguG5mDZupzXGgEGnvzNKa.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 3, 'destino_id' => 1, 'url_imagen' => 'imagenes/destinos/8ZkZpzLqiAtX4396RoE0s0uaP8spaK1SoPYFdk8B.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 4, 'destino_id' => 1, 'url_imagen' => 'imagenes/destinos/Sq8CSd58chSgjybo0s42dOpv7FCJI8CfQkBWlELr.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 5, 'destino_id' => 2, 'url_imagen' => 'imagenes/destinos/4C1H4tFEXn8IspFhKRLlTBiNU7n0XqP8Bo9lzvHr.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 6, 'destino_id' => 2, 'url_imagen' => 'imagenes/destinos/nalzC4nrYYteZfEPzZfPpnXHUeykyr80r5GDBSI2.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 7, 'destino_id' => 2, 'url_imagen' => 'imagenes/destinos/hKfCrxqsbhgkBHPKl3RHcruii0YTJMZyS8wKovB8.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 8, 'destino_id' => 3, 'url_imagen' => 'imagenes/destinos/whpVTKxXF1pAtj1xHze7RClLGkHv5BYQhTcejTIq.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 9, 'destino_id' => 3, 'url_imagen' => 'imagenes/destinos/p2jIMI80oDCl6xF9ulbaGUTyO6bQyFP50Rokz8bv.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 10, 'destino_id' => 3, 'url_imagen' => 'imagenes/destinos/w6fkdkRZ4tt9j0v3iXze8ELKoNCJai7sgeMyx3rD.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 12, 'destino_id' => 3, 'url_imagen' => 'imagenes/destinos/enDlX5GXApUH6nqH0xZjTddPpvIB1s7iYBhdqpam.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 13, 'destino_id' => 4, 'url_imagen' => 'destino_imagenes/TqK5eCar478onMOM7PFuDPwtkpBxxFZWoK8sj1Sp.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 14, 'destino_id' => 4, 'url_imagen' => 'imagenes/destinos/5DQP1JNISHvfeoat0XIMsh1NFTs7nPnMIWwHpCrZ.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 15, 'destino_id' => 6, 'url_imagen' => 'imagenes/destinos/HxQHHPxaYxFB2Ww3ADn58xlrNJW8d7KaCQj6ueFI.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 16, 'destino_id' => 6, 'url_imagen' => 'imagenes/destinos/DY3E87jcTGWZSUZFLSSg8DWghBjaBenmBsrmkwmq.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 17, 'destino_id' => 6, 'url_imagen' => 'imagenes/destinos/gDpEEbPYnqRa8iYR77yQYUHWYQQ6oWabN5VM9wSM.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 18, 'destino_id' => 6, 'url_imagen' => 'imagenes/destinos/FWjNBzUWBM2DyeX0FAuJ8141OUCmiwEAT9mhFMjr.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 19, 'destino_id' => 7, 'url_imagen' => 'imagenes/destinos/QsHBv9cDmmDeBzjawWtfQ7OeVPNVd6TuPRG1r3iP.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 20, 'destino_id' => 7, 'url_imagen' => 'imagenes/destinos/eey73dQHpkRZsIzqCTksajMOcYZ76z8WQhyvvoP9.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 21, 'destino_id' => 7, 'url_imagen' => 'imagenes/destinos/rvNUaMVFq409FkUyotwpySG6JGWrf2yLiOAIbdxK.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 22, 'destino_id' => 7, 'url_imagen' => 'imagenes/destinos/dXZjdmiMXd7v5VKRPYvk4XxzlnS2F2Ku71WJbSHU.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 23, 'destino_id' => 7, 'url_imagen' => 'imagenes/destinos/eQmebwcVqsDoWAq03zhR7aGxcH0J1iy4CTBcbE3n.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 24, 'destino_id' => 5, 'url_imagen' => 'imagenes/destinos/gI37myiXUUQyM1qKEssQjbD9ddRDmFCOYD0GUVhq.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 25, 'destino_id' => 5, 'url_imagen' => 'imagenes/destinos/alhoBGH8bsKnXrutlY8sPdpefRn8U53kmNN62uzt.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 26, 'destino_id' => 5, 'url_imagen' => 'imagenes/destinos/EcFv4QHvS3Mm1335xXz8Yj5PQ81STy4bVteYs8Lz.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 27, 'destino_id' => 5, 'url_imagen' => 'imagenes/destinos/e9QKXnxplhwBumVlh216kmX931xeWud5WYVSXbk8.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 28, 'destino_id' => 5, 'url_imagen' => 'imagenes/destinos/imww0GfvVheA6DMsZq4icYmNqGyuWwvsu0h0K4J6.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 29, 'destino_id' => 12, 'url_imagen' => 'imagenes/destinos/wNcKi8mSRjVezRugFajR6QDhPZFPSzsX6mPuRcqd.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 30, 'destino_id' => 12, 'url_imagen' => 'imagenes/destinos/Mwh0Dqdd0vXuXtmsUgVWOywMhYofRcKaDXL4iAv5.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 31, 'destino_id' => 12, 'url_imagen' => 'imagenes/destinos/7xlFZnvWkuxm1MHVZy5rwxicpiNhSqdBbAIWYVWt.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 32, 'destino_id' => 13, 'url_imagen' => 'imagenes/destinos/ywSdUaN6vDFwn7QMAmB9V04RBERbtJ3AbEpJIZne.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 33, 'destino_id' => 13, 'url_imagen' => 'imagenes/destinos/j9fU1okiUXrxPB3k4YXxoWp93bLK07KaYs04owpZ.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 34, 'destino_id' => 13, 'url_imagen' => 'imagenes/destinos/mQG7LgGOaxU90uoBTdxSp0x1y5deYGA1kMvP4ksK.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 35, 'destino_id' => 14, 'url_imagen' => 'imagenes/destinos/FmDjkSd6RdPwWg3t95MpBrB5GNjKYr3JW6cpVnq5.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 36, 'destino_id' => 14, 'url_imagen' => 'imagenes/destinos/yrtZoQqm24kdf0RPaCadowjlRxxY32FW8BqvelAO.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 37, 'destino_id' => 14, 'url_imagen' => 'imagenes/destinos/digFwVgN3CmHUQsmdoHPv7OVW1n7tvvQeLTkiK3Z.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 38, 'destino_id' => 15, 'url_imagen' => 'imagenes/destinos/ZJS6dzsecFux2KOCozWbdJkEHpbWTkAAgql9jWIV.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 39, 'destino_id' => 15, 'url_imagen' => 'imagenes/destinos/etdg6rz9Wjor6FFOIMFFwaPrpltGLflDnXraspMW.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 40, 'destino_id' => 15, 'url_imagen' => 'imagenes/destinos/YZikB9bNTk4TvPKBEw0YcTKnrpnCRV37dPDPP4n0.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 41, 'destino_id' => 15, 'url_imagen' => 'imagenes/destinos/ALobRaaSmCuqZVhTJwHkeipFQu86vs4E3kNwCNoC.png', /*... otros campos ...*/]);
        DestinoImagen::create(['id' => 42, 'destino_id' => 15, 'url_imagen' => 'imagenes/destinos/oyuV9JpYbBE6p90ICgiVjOb1cPKwtLugJKnqzpiE.png', /*... otros campos ...*/]);
        Comentario::create(['id' => 1, 'user_id' => 4, 'diario_id' => 5, 'contenido' => 'Me encantaron tus inspiraciones 😎', /*... otros campos ...*/]);
        Comentario::create(['id' => 2, 'user_id' => 4, 'diario_id' => 2, 'contenido' => 'Experiencias increíbles', /*... otros campos ...*/]);
        Comentario::create(['id' => 3, 'user_id' => 1, 'diario_id' => 1, 'contenido' => '😎 Menudo frío que hacía', /*... otros campos ...*/]);
        Comentario::create(['id' => 4, 'user_id' => 6, 'diario_id' => 4, 'contenido' => 'Esta genial 😎', /*... otros campos ...*/]);
        Comentario::create(['id' => 5, 'user_id' => 1, 'diario_id' => 4, 'contenido' => 'Estubo genial', /*... otros campos ...*/]);
        Friendship::create([
            'user_id' => 5,
            'friend_id' => 1,
            'status' => 'aceptada',
        ]);
        Friendship::create([
            'user_id' => 5,
            'friend_id' => 2,
            'status' => 'pendiente',
        ]);
        Friendship::create([
            'user_id' => 5,
            'friend_id' => 3,
            'status' => 'aceptada',
        ]);
        Friendship::create([
            'user_id' => 3,
            'friend_id' => 4,
            'status' => 'aceptada',
        ]);
        Friendship::create([
            'user_id' => 3,
            'friend_id' => 2,
            'status' => 'pendiente',
        ]);
        Friendship::create([
            'user_id' => 3,
            'friend_id' => 5,
            'status' => 'aceptada',
        ]);
        Friendship::create([
            'user_id' => 1,
            'friend_id' => 5,
            'status' => 'aceptada',
        ]);
        Friendship::create([
            'user_id' => 1,
            'friend_id' => 4,
            'status' => 'aceptada',
        ]);
        Friendship::create([
            'user_id' => 4,
            'friend_id' => 3,
            'status' => 'aceptada',
        ]);
        Friendship::create([
            'user_id' => 4,
            'friend_id' => 1,
            'status' => 'aceptada',
        ]);
        Friendship::create([
            'user_id' => 4,
            'friend_id' => 2,
            'status' => 'pendiente',
        ]);
        Friendship::create([
            'user_id' => 6,
            'friend_id' => 5,
            'status' => 'pendiente',
        ]);
        Friendship::create([
            'user_id' => 6,
            'friend_id' => 3,
            'status' => 'pendiente',
        ]);
        Friendship::create([
            'user_id' => 1,
            'friend_id' => 6,
            'status' => 'pendiente',
        ]);
        DB::table('favoritos_diarios')->insert(['user_id' => 6, 'diario_id' => 5]);
        DB::table('favoritos_diarios')->insert(['user_id' => 4, 'diario_id' => 4]);
        DB::table('favoritos_diarios')->insert(['user_id' => 4, 'diario_id' => 6]);
        DB::table('favoritos_diarios')->insert(['user_id' => 4, 'diario_id' => 7]);
        DB::table('favoritos_diarios')->insert(['user_id' => 4, 'diario_id' => 5]);
        DB::table('favoritos_diarios')->insert(['user_id' => 1, 'diario_id' => 1]);
        DB::table('favoritos_diarios')->insert(['user_id' => 5, 'diario_id' => 2]);
        DB::table('favoritos_diarios')->insert(['user_id' => 5, 'diario_id' => 4]);
        DB::table('favoritos_diarios')->insert(['user_id' => 5, 'diario_id' => 1]);
        DB::table('favoritos_diarios')->insert(['user_id' => 6, 'diario_id' => 4]);
        DB::table('favoritos_diarios')->insert(['user_id' => 1, 'diario_id' => 2]);
        DB::table('favoritos_diarios')->insert(['user_id' => 1, 'diario_id' => 4]);
    }
}
