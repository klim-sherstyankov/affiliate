<?php

namespace App\DataFixtures;

use App\Entity\Items;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ItemsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Items();
        $product->setUrl('https://www.letu.ru/product/lalique-encre-noire/1281');
        $product->setDescription('Чисто мужской классический Encre Noire — настоящий гимн аристократизму и ментальной зрелости. Представитель мужского пола, выбирающий древесный аромат от LALIQUE, уверен в себе, привлекает благородством и чувством стиля.

Умиротворенный и солидно-спокойный темперамент парфюма прослеживается в первых нотах зеленого кипариса, обдающего волной лесной свежести. Сменяясь сердцевиной из пряного ветивера, он плавно перетекает в оттенки бурбонского, гаитянского и египетского вида, принося ощущение дымно-мускусного присутствия тропической природы.

Бархатное, слегка сладкое звучание придают в основе букета пудровый кашмирский мускус и горячие древесные ноты. Настоящая классика. В меру изысканный, сложный и брутальный. Шик давно забытых лет.

История флакона не менее знаменита, чем сам легендарный запах. Выполненная в виде непрозрачной чернильницы бутылочка в точности повторяет модель «Biches», созданную в 1913 году самим Рене Лаликом.');
        $product->setPrice(4979);
        $product->setPriceOffPercent(40);
        $product->setShortName('LALIQUE Encre Noire');
        $product->setImage('https://www.letu.ru/common/img/pim/2023/09/EX_0389937b-6cf0-4ffd-bc46-fc368b99e9ce.jpg');
        $product->setShopName('Летуаль');
        $product->setSalePrice(8299);
        $manager->persist($product);

        $manager->flush();
    }
}
