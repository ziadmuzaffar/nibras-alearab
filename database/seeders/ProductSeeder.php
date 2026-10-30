<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_slug' => 'luxury-packaging-boxes',
                'name' => [
                    'ar' => 'علب كرتون فاخرة مغناطيسية مخصصة',
                    'en' => 'Custom Luxury Magnetic Rigid Gift Boxes',
                ],
                'slug' => 'luxury-magnetic-gift-boxes',
                'short_description' => [
                    'ar' => 'علب صلبة كرتونية فاخرة بنظام قفل مغناطيسي خفي وتصميم مخصص للهدايا والمنتجات الراقية.',
                    'en' => 'Premium rigid cardboard boxes with hidden magnetic closure and custom design for luxury gifts and products.',
                ],
                'description' => [
                    'ar' => 'نقدم تصنيع وتفصيل علب الهدايا الفاخرة ذات الإغلاق المغناطيسي بأعلى معايير الدقة والجودة، مع إمكانية إضافة لمسات فاخرة من الفويل الذهبي أو الفضي وطباعة السبوت يو في (Spot UV)، وبطانة إسفنجية مخملية لحماية المنتجات وإبراز جمالها.',
                    'en' => 'We manufacture custom luxury magnetic-closure gift boxes to the highest standards of precision and quality, featuring optional gold or silver hot foil stamping, raised Spot UV, and velvet-lined laser-cut foam inserts to protect and showcase your products.',
                ],
                'specifications' => [
                    'ar' => [
                        'الخامة' => 'كرتون رمادي مضغوط صلب 2 مم مكسو بورق كوشيه 157 جم',
                        'نوع الإغلاق' => 'مغناطيس نيوديميوم قوي مدمج ومخفي',
                        'التشطيب الخارجي' => 'سلوفان مطفي ناعم الملمس (Soft Touch) + بصمة ذهبية حرارية',
                        'التجهيز الداخلي' => 'قالب إسفنجي مخصص مقصوص بالليزر مع كسوة قماش قطيفة',
                        'الحد الأدنى للطلب' => '100 علبة',
                    ],
                    'en' => [
                        'Material' => '2mm rigid greyboard wrapped with 157gsm coated art paper',
                        'Closure Type' => 'Built-in hidden strong neodymium magnet',
                        'Exterior Finish' => 'Soft-touch matte lamination + hot gold foil stamping',
                        'Interior Insert' => 'Custom laser-cut EVA foam lined with luxury velvet',
                        'Minimum Order' => '100 Boxes',
                    ],
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'is_active' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'category_slug' => 'luxury-packaging-boxes',
                'name' => [
                    'ar' => 'كراتين شحن مضلعة ومطبوعة للعلامات التجارية',
                    'en' => 'Custom Printed Corrugated Shipping Mailer Boxes',
                ],
                'slug' => 'custom-printed-shipping-boxes',
                'short_description' => [
                    'ar' => 'كراتين شحن قوية مضلعة بطباعة هوية وشعار متجرك لحماية الشحنات وإبراز هويتك.',
                    'en' => 'Durable corrugated shipping boxes custom printed with your store logo and branding for safe delivery.',
                ],
                'description' => [
                    'ar' => 'نوفر كراتين شحن قوية متعددة الطبقات من الكرتون المضلع المموج عالي التحمل، مع طباعة ملونة لشعار وهوية متجرك الإلكتروني لتقديم تجربة فتح صندوق (Unboxing Experience) استثنائية واحترافية لعملائك تزيد من ولائهم للعلامة التجارية.',
                    'en' => 'We provide heavy-duty multi-layer corrugated shipping mailer boxes with full-color inside and outside printing of your e-commerce brand identity, delivering an unforgettable unboxing experience that boosts customer loyalty.',
                ],
                'specifications' => [
                    'ar' => [
                        'النوع' => 'كرتون مضلع ثلاثي الطبقات متين (E-Flute / B-Flute)',
                        'الطباعة' => 'طباعة فلكسو / أوفست بألوان كاملة CMYK من الداخل والخارج',
                        'التحمل' => 'قدرة تحمل شحن وتوزيع حتى 10 كجم',
                        'خيارات الحجم' => 'أحجام متعددة قياسية ومقاسات مخصصة حسب الطلب',
                        'الحد الأدنى للطلب' => '300 كرتون',
                    ],
                    'en' => [
                        'Board Type' => 'Durable 3-ply corrugated board (E-Flute / B-Flute)',
                        'Printing' => 'Full-color CMYK Flexo / Offset printing inside & outside',
                        'Load Capacity' => 'Supports shipping weights up to 10 kg',
                        'Size Options' => 'Multiple standard sizes & custom dimensions on request',
                        'Minimum Order' => '300 Boxes',
                    ],
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'is_active' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'category_slug' => 'business-cards',
                'name' => [
                    'ar' => 'كروت شخصية فاخرة بالبصمة الحرارية واليو في',
                    'en' => 'Luxury Gold Foil & Spot UV Business Cards',
                ],
                'slug' => 'luxury-gold-foil-business-cards',
                'short_description' => [
                    'ar' => 'بطاقات عمل أنيقة بلمسات البصمة الذهبية وتقنية اليو في البارز لتترك انطباعاً أولاً لا يُنسى.',
                    'en' => 'Elegant business cards with hot gold foil stamping and raised Spot UV for an unforgettable first impression.',
                ],
                'description' => [
                    'ar' => 'بطاقات عمل استثنائية مصنوعة من أجود أنواع الورق الفاخر المقوى مع لمسات الفويل الذهبي أو الفضي اللامع وتقنية الورنيش الموضعي البارز (Spot UV) التي تبرز شعارك وتفاصيل هويتك بلمسة حسية وبصرية راقية.',
                    'en' => 'Exceptional business cards crafted from premium heavy cardstock featuring metallic gold or silver foil stamping and raised Spot UV coating that highlights your logo and brand identity with refined tactile appeal.',
                ],
                'specifications' => [
                    'ar' => [
                        'المقاس' => '9 × 5.5 سم (المقاس القياسي للشركات)',
                        'نوع الورق' => 'كوشيه مقوى ألماني 400 جرام مع سلفنة مطفية حريرية',
                        'المؤثرات الخاصة' => 'بصمة ذهبية حرارية + طبقة ورنيش UV موضعي بارز',
                        'الزوايا' => 'زوايا قائمة حادة أو دائرية ناعمة',
                        'الكمية' => 'تبدأ من 500 كرت',
                    ],
                    'en' => [
                        'Dimensions' => '9 × 5.5 cm (Standard Corporate Size)',
                        'Paper Stock' => '400gsm German heavy art card with silk matte lamination',
                        'Special Finishes' => 'Hot gold foil stamping + raised Spot UV varnish',
                        'Corners' => 'Sharp square corners or smooth rounded corners',
                        'Quantity' => 'Starting from 500 cards',
                    ],
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'is_active' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'category_slug' => 'business-cards',
                'name' => [
                    'ar' => 'كروت شخصية قطنية مع لتربرس وتذهيب الحواف',
                    'en' => 'Cotton Letterpress Business Cards with Gilded Edges',
                ],
                'slug' => 'cotton-letterpress-edge-foil-cards',
                'short_description' => [
                    'ar' => 'كروت أعمال مصنوعة من ورق القطن الطبيعي السميك مع حفر غائر وتذهيب يدوي للأطراف.',
                    'en' => 'Ultra-thick natural cotton business cards featuring deep letterpress debossing and hand-gilded edges.',
                ],
                'description' => [
                    'ar' => 'الخيار الأرقى للقيادات التنفيذية وأصحاب المهن الرفيعة. تُطبع هذه البطاقات على ورق قطني نقي 600 جرام بتقنية الطباعة بالحفر الغائر والبارز (Letterpress)، مع تذهيب حواف الكرت بالذهب المعدني اللامع لإضفاء طابع كلاسيكي ساحر.',
                    'en' => 'The ultimate choice for executives and distinguished professionals. Printed on 600gsm pure cotton paper using traditional letterpress debossing, finished with metallic gold edge gilding for timeless sophistication.',
                ],
                'specifications' => [
                    'ar' => [
                        'الورق' => 'قطني طبيعي 100% سماكة فائقة 600 جرام',
                        'طريقة الطباعة' => 'طباعة حفر غائر عتيقة (Letterpress Debossing)',
                        'الحواف' => 'تذهيب يدوي فاخر لحواف الكرت (Gilded / Foiled Edges)',
                        'اللون' => 'أبيض عاجي أو أبيض ناصع مع تذهيب ذهبي / نحاسي',
                        'الكمية' => 'تبدأ من 250 كرت',
                    ],
                    'en' => [
                        'Paper Stock' => '100% pure natural cotton, ultra-thick 600gsm',
                        'Printing Method' => 'Traditional Letterpress Debossing',
                        'Edges' => 'Hand-crafted metallic gilded / foiled edges',
                        'Color' => 'Ivory white or bright white with gold / copper gilding',
                        'Quantity' => 'Starting from 250 cards',
                    ],
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'is_active' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'category_slug' => 'paper-and-fabric-bags',
                'name' => [
                    'ar' => 'أكياس ورقية كرافت صديقة للبيئة مع مقابض مجدولة',
                    'en' => 'Eco-Friendly Kraft Paper Bags with Twisted Handles',
                ],
                'slug' => 'eco-friendly-kraft-paper-bags',
                'short_description' => [
                    'ar' => 'أكياس تسوق ورقية صديقة للبيئة من ورق الكرافت الطبيعي المتين مع طباعة مخصصة لشعارك.',
                    'en' => 'Sustainable shopping bags made from durable natural kraft paper with custom logo printing.',
                ],
                'description' => [
                    'ar' => 'خيار مثالي للمتاجر ومنافذ البيع والمقاهي العصرية، مصنوعة من ورق الكرافت القوي والمتين والمقاوم للتمزق، وتتحمل الأوزان المختلفة مع تدعيم القاعدة ومقابض ورقية مجدولة مريحة وطباعة عالية الوضوح.',
                    'en' => 'An ideal choice for retail stores, boutiques, and modern cafés. Crafted from tear-resistant heavy kraft paper with reinforced bottoms, comfortable twisted paper handles, and crisp custom branding.',
                ],
                'specifications' => [
                    'ar' => [
                        'الخامة' => 'ورق كرافت طبيعي صديق للبيئة وقابل للتدوير 180 جرام',
                        'الألوان المتاحة' => 'بني طبيعي، أبيض نقي',
                        'المقابض' => 'ورق مجدول متين أو حبال قطنية ناعمة',
                        'المقاسات المتوفرة' => 'صغير (22x15 سم)، وسط (32x26 سم)، كبير (42x31 سم)',
                        'الحد الأدنى' => '500 كيس',
                    ],
                    'en' => [
                        'Material' => '180gsm recyclable eco-friendly natural kraft paper',
                        'Available Colors' => 'Natural Brown, Pure White',
                        'Handles' => 'Strong twisted paper handles or soft cotton ropes',
                        'Available Sizes' => 'Small (22x15 cm), Medium (32x26 cm), Large (42x31 cm)',
                        'Minimum Order' => '500 Bags',
                    ],
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'is_active' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'category_slug' => 'paper-and-fabric-bags',
                'name' => [
                    'ar' => 'أكياس كوشيه فاخرة للمعارض مع أشرطة ستان حريرية',
                    'en' => 'Luxury Coated Boutique Bags with Satin Ribbon Handles',
                ],
                'slug' => 'luxury-glossy-coated-bags',
                'short_description' => [
                    'ar' => 'أكياس كوشيه سميكة مع طبقة حماية سلفنة وأشرطة ستان ملكية للمعارض والمتاجر الراقية.',
                    'en' => 'Thick art-paper bags with protective lamination and royal satin ribbon handles for exhibitions and luxury boutiques.',
                ],
                'description' => [
                    'ar' => 'أكياس بوتيكات ومعارض فاخرة مصنوعة من ورق الكوشيه السميك، مع طباعة ملونة وتفاصيل بارزة وشرائط ستان حريرية ناعمة تعكس فخامة المنتجات المحمولة بداخلها.',
                    'en' => 'Premium boutique and exhibition shopping bags made from heavy coated art paper, featuring full-color offset printing, foil accents, and silky satin ribbon handles that reflect the prestige of your brand.',
                ],
                'specifications' => [
                    'ar' => [
                        'الخامة' => 'ورق كوشيه فاخر 250 جرام مدعم بقواعد كرتونية في الأعلى والأسفل',
                        'التشطيب' => 'سلوفان مطفي فاخر (Matte Lamination) + بصمة ذهبية للشعار',
                        'المقابض' => 'شرائط قماشية ستان حريري عريضة بألوان متناسقة',
                        'الحد الأدنى' => '500 كيس',
                    ],
                    'en' => [
                        'Material' => '250gsm luxury art paper with reinforced top & bottom cardboard inserts',
                        'Finish' => 'Luxury Matte Lamination + gold foil logo stamping',
                        'Handles' => 'Wide silky satin ribbons in matching brand colors',
                        'Minimum Order' => '500 Bags',
                    ],
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'is_active' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'category_slug' => 'books-and-catalogues',
                'name' => [
                    'ar' => 'طباعة كتالوجات وملفات تعريف الشركات (Company Profiles)',
                    'en' => 'Corporate Company Profiles & Product Catalogues Printing',
                ],
                'slug' => 'corporate-company-profile-catalogues',
                'short_description' => [
                    'ar' => 'كتالوجات وملفات تعريفية احترافية بتجليد فاخر وطباعة ألوان دقيقة تبرز إنجازات شركتك.',
                    'en' => 'Professional company profiles and catalogues with luxury binding and color-accurate printing.',
                ],
                'description' => [
                    'ar' => 'بروفايلات وكتالوجات تعريفية تعكس المكانة الحقيقية لأعمالك، مع خيارات تجليد متعددة مثل الدبوس، السلك المعدني، أو التجليد الفاخر بالغراء الحراري (Perfect Binding) والكرتون المقوى (Hardcover) مع إضافة السلوفان والبصمة.',
                    'en' => 'Company profiles and product catalogues that showcase your corporate achievements, offering saddle stitching, wire-o, thermal perfect binding, or hardcover finishes with matte lamination and Spot UV.',
                ],
                'specifications' => [
                    'ar' => [
                        'الغلاف' => 'كرتون مقوى 350 جم بسلوفان حراري مطفي + يو في موضعي',
                        'الصفحات الداخلية' => 'ورق كوشيه ألماني مطفي 150 جم',
                        'نوع التجليد' => 'غراء حراري فاخر (Perfect Binding) أو سلك معدني أنيق',
                        'المقاسات' => 'A4 رأسي أو أفقي، A5، ومقاسات مربعة خاصة',
                    ],
                    'en' => [
                        'Cover' => '350gsm heavy cardstock with thermal matte lamination + Spot UV',
                        'Inner Pages' => '150gsm German matte coated art paper',
                        'Binding Options' => 'Thermal Perfect Binding, Saddle Stitch, or Wire-O',
                        'Sizes' => 'A4 Portrait/Landscape, A5, and custom square formats',
                    ],
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'is_active' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'category_slug' => 'labels-and-stickers',
                'name' => [
                    'ar' => 'ستيكرات فينيل وقص مخصص مقاومة للماء (Die-Cut)',
                    'en' => 'Waterproof Custom Die-Cut Vinyl Stickers & Labels',
                ],
                'slug' => 'waterproof-vinyl-die-cut-stickers',
                'short_description' => [
                    'ar' => 'ملصقات فينيل ضد الماء والحرارة مقصوصة بالليزر على حدود التصميم بدقة رقمية فائقة.',
                    'en' => 'Waterproof and heat-resistant vinyl stickers laser cut to your exact artwork contour.',
                ],
                'description' => [
                    'ar' => 'ستيكرات عالية التحمل ومقاومة للماء والرطوبة وأشعة الشمس والخدش، مثالية للعبوات الزجاجية والبلاستيكية والأجهزة والتغليف بجميع الأشكال الهندسية والقص المخصص وفق هوية علامتك.',
                    'en' => 'High-durability vinyl labels resistant to water, oils, humidity, UV rays, and scratches—perfect for glass jars, cosmetic bottles, coffee pouches, and custom packaging in any die-cut shape.',
                ],
                'specifications' => [
                    'ar' => [
                        'المادة' => 'فينيل بوليمري عالي الجودة (أبيض، شفاف، أو هولوجرام ثلاثي الأبعاد)',
                        'المقاومة' => 'مقاوم للماء، الرطوبة، والحرارة حتى 80 درجة مئوية',
                        'طريقة القص' => 'قص ليزري دقيق على حدود التصميم (Die-Cut / Kiss-Cut)',
                        'طريقة التوريد' => 'قطع مفردة، شيتات مقسمة، أو رولات مخصصة للمكائن',
                    ],
                    'en' => [
                        'Material' => 'Premium polymeric vinyl (White, Clear, or 3D Hologram)',
                        'Durability' => 'Waterproof, oil-proof, and heat-resistant up to 80°C',
                        'Cutting Method' => 'Precision laser contour cutting (Die-Cut / Kiss-Cut)',
                        'Supply Format' => 'Individual pieces, kiss-cut sheets, or machine-ready rolls',
                    ],
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1572375992501-4b0892d50c69?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'is_active' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1572375992501-4b0892d50c69?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'category_slug' => 'corporate-stationery',
                'name' => [
                    'ar' => 'طقم مطبوعات ورقية ومراسلات رسمية للشركات',
                    'en' => 'Complete Corporate Stationery & Letterhead Suite',
                ],
                'slug' => 'complete-corporate-stationery-pack',
                'short_description' => [
                    'ar' => 'باقة متكاملة من الأوراق الرسمية والمظاريف والمجلدات المصممة لتعزيز الحضور المهني.',
                    'en' => 'A complete corporate package of official letterheads, envelopes, and presentation folders.',
                ],
                'description' => [
                    'ar' => 'تشكيلة متكاملة من المطبوعات الرسمية والمكتبية للشركات، تشمل أوراق المراسلات والفواتير (Letterhead) المتوافقة مع الطابعات الليزرية، وأظرف المراسلات بأحجامها المتعددة، وفولدرات العقود بجيب داخلي متين لحفظ المستندات وبطاقة العمل.',
                    'en' => 'A comprehensive suite of official corporate stationery including laser-printer compatible letterheads, custom-printed envelopes in multiple sizes, and contract presentation folders with interior pockets and business card slots.',
                ],
                'specifications' => [
                    'ar' => [
                        'ورق المراسلات' => 'ورق وود فري 100 جرام ألماني ناصع البياض ملائم لكافة الطابعات',
                        'المظاريف' => 'مقاس DL للأوراق المطوية ومقاس A4 مع شريط لاصق ذاتي التثبيت',
                        'الفولدرات' => 'كرتون مقوى 350 جرام بسلوفان حماية وجيب داخلي مع شق لكروت العمل',
                    ],
                    'en' => [
                        'Letterheads' => '100gsm German bright white woodfree paper compatible with laser/inkjet printers',
                        'Envelopes' => 'DL and A4 sizes with convenient self-seal adhesive strips',
                        'Folders' => '350gsm cardstock with protective lamination, inner pocket & business card slot',
                    ],
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'is_active' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'category_slug' => 'banners-and-rollups',
                'name' => [
                    'ar' => 'ستاند رول اب إعلاني مع الطباعة والحقيبة المبطنة',
                    'en' => 'Premium Roll-Up Display Stand with Print & Padded Case',
                ],
                'slug' => 'premium-advertising-rollup-stand',
                'short_description' => [
                    'ar' => 'ستاندات رول اب إعلانية سهلة الفك والتركيب والتنقل للمؤتمرات والمعارض والفعاليات.',
                    'en' => 'Portable, easy-to-assemble roll-up banner stands for conferences, exhibitions, and events.',
                ],
                'description' => [
                    'ar' => 'ستاند ألومنيوم متين وقوي خفيف الوزن مع خامة طباعة عالية الجودة غير عاكسة للضوء ومقاومة للالتفاف، مرفق بحقيبة قماشية مبطنة لسهولة الحمل والتنقل في المعارض والفعاليات التسويقية.',
                    'en' => 'Sturdy lightweight aluminum roll-up mechanism paired with anti-glare, curl-resistant high-resolution PP banner film, complete with a padded shoulder carry bag for effortless transport.',
                ],
                'specifications' => [
                    'ar' => [
                        'المقاس المتوفر' => '85 × 200 سم / 120 × 200 سم / 150 × 200 سم',
                        'هيكل الستاند' => 'ألومنيوم خفيف الوزن مع أرجل اتزان عريضة وقضيب تثبيت علوي كليبس',
                        'مادة الطباعة' => 'فيلم بولي بروبلين (PP Film) فاخر مانع لانعكاس الإضاءة ومقاوم للتمزق',
                        'الملحقات' => 'حقيبة قماشية مبطنة بحزام كتف لحماية الستاند أثناء التنقل',
                    ],
                    'en' => [
                        'Available Sizes' => '85 × 200 cm / 120 × 200 cm / 150 × 200 cm',
                        'Stand Structure' => 'Heavy-duty lightweight aluminum base with wide stabilizing feet',
                        'Print Media' => 'Anti-glare, tear-resistant premium Polypropylene (PP) film',
                        'Accessories' => 'Padded canvas carrying bag with shoulder strap included',
                    ],
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'is_active' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'category_slug' => 'promotional-gifts',
                'name' => [
                    'ar' => 'دروع كريستالية تذكارية فاخرة مع حفر ليزري',
                    'en' => 'Luxury K9 Crystal Trophy Awards with Laser Engraving',
                ],
                'slug' => 'crystal-trophy-awards',
                'short_description' => [
                    'ar' => 'دروع تكريم كريستال نقي بتصميم هندسي راقٍ وحفر ليزري داخلي أو خارجي مع علبة فاخرة.',
                    'en' => 'Pure optical crystal recognition trophies with precision 3D laser engraving and velvet presentation box.',
                ],
                'description' => [
                    'ar' => 'دروع تكريمية فخمة مصنوعة من الكريستال النقي بدرجة نقاء K9، تقدم في مناسبات التكريم، والتخرج، والاحتفالات الرسمية وتكريم الموظفين، مع إمكانية الحفر الليزري المخصص للشعار والنصوص وإضافة ألوان، مرفقة بعلبة هدايا فاخرة.',
                    'en' => 'Prestigious recognition awards crafted from optical-grade K9 crystal for corporate ceremonies, graduations, and VIP appreciation, featuring custom 3D laser engraving or UV color printing in a velvet-lined gift box.',
                ],
                'specifications' => [
                    'ar' => [
                        'الخامة' => 'كريستال بصري K9 عالي النقاوة بلمعان فائق',
                        'تقنية الحفر' => 'حفر ليزر ثلاثي الأبعاد عالي الدقة أو طباعة UV ملونة مقاومة للخدش',
                        'العلبة' => 'علبة هدايا كرتونية فاخرة بقفل مغناطيسي وبطانة حريرية ملكية',
                        'الأبعاد' => 'ارتفاع 22 سم إلى 30 سم بقاعدة سميكة متزنة',
                    ],
                    'en' => [
                        'Material' => 'High-purity K9 optical crystal with diamond-polished edges',
                        'Engraving Tech' => 'High-precision 3D laser engraving or scratch-resistant UV color print',
                        'Presentation Box' => 'Luxury magnetic gift box with royal satin/velvet lining',
                        'Dimensions' => '22 cm to 30 cm height with solid weighted crystal base',
                    ],
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'is_active' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'category_slug' => 'official-stamps',
                'name' => [
                    'ar' => 'أختام رسمية أوتوماتيكية دائرية ومستطيلة',
                    'en' => 'Official Automatic Self-Inking Corporate Stamps',
                ],
                'slug' => 'official-automatic-self-inking-stamps',
                'short_description' => [
                    'ar' => 'أختام رسمية معتمدة بتقنية الحبر الذاتي الأوتوماتيكي وحفر ليزري للمطاط فائق الدقة.',
                    'en' => 'Certified self-inking official stamps with high-precision laser-engraved rubber plates.',
                ],
                'description' => [
                    'ar' => 'أختام رسمية معتمدة للشركات والمؤسسات والعيادات والمكاتب القانونية، حفر ليزري عالي الدقة يضمن وضوح أدق التفاصيل والشعارات المعقدة لآلاف المرات دون الحاجة لإعادة التعبئة.',
                    'en' => 'Certified corporate stamps for companies, clinics, and legal offices. High-precision laser engraving ensures crisp impressions of intricate logos and text for thousands of uses.',
                ],
                'specifications' => [
                    'ar' => [
                        'النوع' => 'ختم أوتوماتيكي بحبر مدمج ذاتي (Self-Inking)',
                        'الشكل' => 'دائري (قطر 40 مم) أو مستطيل (60 × 25 مم)',
                        'ألوان الحبر' => 'أزرق ملكي، أحمر، أسود، أو أخضر',
                        'عمر الحبر' => 'يكفي لأكثر من 10,000 طبعة مع إمكانية استبدال وسادة الحبر بسهولة',
                    ],
                    'en' => [
                        'Type' => 'Automatic built-in self-inking mechanism',
                        'Shape' => 'Round (40mm diameter) or Rectangular (60 × 25mm)',
                        'Ink Colors' => 'Royal Blue, Red, Black, or Green',
                        'Pad Lifespan' => 'Over 10,000 clean impressions with replaceable ink pad',
                    ],
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'is_active' => false,
                'images' => [
                    'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
                ],
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('slug', $productData['category_slug'])->first();

            if (! $category) {
                continue;
            }

            $images = $productData['images'] ?? [];
            unset($productData['category_slug'], $productData['images']);

            $productData['category_id'] = $category->id;

            $product = Product::updateOrCreate(
                ['slug' => $productData['slug']],
                $productData
            );

            // Recreate gallery images for this product
            ProductImage::where('product_id', $product->id)->delete();

            foreach ($images as $index => $imagePath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'sort_order' => $index + 1,
                ]);
            }
        }
    }
}
