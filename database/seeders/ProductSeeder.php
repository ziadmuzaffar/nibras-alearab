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
                'name' => 'علب كرتون فاخرة مغناطيسية مخصصة',
                'slug' => 'luxury-magnetic-gift-boxes',
                'short_description' => 'علب صلبة كرتونية فاخرة بنظام قفل مغناطيسي خفي وتصميم مخصص للهدايا والمنتجات الراقية.',
                'description' => 'نقدم تصنيع وتفصيل علب الهدايا الفاخرة ذات الإغلاق المغناطيسي بأعلى معايير الدقة والجودة، مع إمكانية إضافة لمسات فاخرة من الفويل الذهبي أو الفضي وطباعة السبوت يو في (Spot UV)، وبطانة إسفنجية مخملية لحماية المنتجات وإبراز جمالها.',
                'specifications' => [
                    'الخامة' => 'كرتون رمادي مضغوط صلب 2 مم مكسو بورق كوشيه 157 جم',
                    'نوع الإغلاق' => 'مغناطيس نيوديميوم قوي مدمج ومخفي',
                    'التشطيب الخارجي' => 'سلوفان مطفي ناعم الملمس (Soft Touch) + بصمة ذهبية حرارية',
                    'التجهيز الداخلي' => 'قالب إسفنجي مخصص مقصوص بالليزر مع كسوة قماش قطيفة',
                    'الحد الأدنى للطلب' => '100 علبة',
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
                'name' => 'كراتين شحن مضلعة ومطبوعة للعلامات التجارية',
                'slug' => 'custom-printed-shipping-boxes',
                'short_description' => 'كراتين شحن قوية مضلعة بطباعة هوية وشعار متجرك لحماية الشحنات وإبراز هويتك.',
                'description' => 'نوفر كراتين شحن قوية متعددة الطبقات من الكرتون المضلع المموج عالي التحمل، مع طباعة ملونة لشعار وهوية متجرك الإلكتروني لتقديم تجربة فتح صندوق (Unboxing Experience) استثنائية واحترافية لعملائك تزيد من ولائهم للعلامة التجارية.',
                'specifications' => [
                    'النوع' => 'كرتون مضلع ثلاثي الطبقات متين (E-Flute / B-Flute)',
                    'الطباعة' => 'طباعة فلكسو / أوفست بألوان كاملة CMYK من الداخل والخارج',
                    'التحمل' => 'قدرة تحمل شحن وتوزيع حتى 10 كجم',
                    'خيارات الحجم' => 'أحجام متعددة قياسية ومقاسات مخصصة حسب الطلب',
                    'الحد الأدنى للطلب' => '300 كرتون',
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
                'name' => 'كروت شخصية فاخرة بالبصمة الحرارية واليو في',
                'slug' => 'luxury-gold-foil-business-cards',
                'short_description' => 'بطاقات عمل أنيقة بلمسات البصمة الذهبية وتقنية اليو في البارز لتترك انطباعاً أولاً لا يُنسى.',
                'description' => 'بطاقات عمل استثنائية مصنوعة من أجود أنواع الورق الفاخر المقوى مع لمسات الفويل الذهبي أو الفضي اللامع وتقنية الورنيش الموضعي البارز (Spot UV) التي تبرز شعارك وتفاصيل هويتك بلمسة حسية وبصرية راقية.',
                'specifications' => [
                    'المقاس' => '9 × 5.5 سم (المقاس القياسي للشركات)',
                    'نوع الورق' => 'كوشيه مقوى ألماني 400 جرام مع سلفنة مطفية حريرية',
                    'المؤثرات الخاصة' => 'بصمة ذهبية حرارية + طبقة ورنيش UV موضعي بارز',
                    'الزوايا' => 'زوايا قائمة حادة أو دائرية ناعمة',
                    'الكمية' => 'تبدأ من 500 كرت',
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
                'name' => 'كروت شخصية قطنية مع لتربرس وتذهيب الحواف',
                'slug' => 'cotton-letterpress-edge-foil-cards',
                'short_description' => 'كروت أعمال مصنوعة من ورق القطن الطبيعي السميك مع حفر غائر وتذهيب يدوي للأطراف.',
                'description' => 'الخيار الأرقى للقيادات التنفيذية وأصحاب المهن الرفيعة. تُطبع هذه البطاقات على ورق قطني نقي 600 جرام بتقنية الطباعة بالحفر الغائر والبارز (Letterpress)، مع تذهيب حواف الكرت بالذهب المعدني اللامع لإضفاء طابع كلاسيكي ساحر.',
                'specifications' => [
                    'الورق' => 'قطني طبيعي 100% سماكة فائقة 600 جرام',
                    'طريقة الطباعة' => 'طباعة حفر غائر عتيقة (Letterpress Debossing)',
                    'الحواف' => 'تذهيب يدوي فاخر لحواف الكرت (Gilded / Foiled Edges)',
                    'اللون' => 'أبيض عاجي أو أبيض ناصع مع تذهيب ذهبي / نحاسي',
                    'الكمية' => 'تبدأ من 250 كرت',
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
                'name' => 'أكياس ورقية كرافت صديقة للبيئة مع مقابض مجدولة',
                'slug' => 'eco-friendly-kraft-paper-bags',
                'short_description' => 'أكياس تسوق ورقية صديقة للبيئة من ورق الكرافت الطبيعي المتين مع طباعة مخصصة لشعارك.',
                'description' => 'خيار مثالي للمتاجر ومنافذ البيع والمقاهي العصرية، مصنوعة من ورق الكرافت القوي والمتين والمقاوم للتمزق، وتتحمل الأوزان المختلفة مع تدعيم القاعدة ومقابض ورقية مجدولة مريحة وطباعة عالية الوضوح.',
                'specifications' => [
                    'الخامة' => 'ورق كرافت طبيعي صديق للبيئة وقابل للتدوير 180 جرام',
                    'الألوان المتاحة' => 'بني طبيعي، أبيض نقي',
                    'المقابض' => 'ورق مجدول متين أو حبال قطنية ناعمة',
                    'المقاسات المتوفرة' => 'صغير (22x15 سم)، وسط (32x26 سم)، كبير (42x31 سم)',
                    'الحد الأدنى' => '500 كيس',
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
                'name' => 'أكياس كوشيه فاخرة للمعارض مع أشرطة ستان حريرية',
                'slug' => 'luxury-glossy-coated-bags',
                'short_description' => 'أكياس كوشيه سميكة مع طبقة حماية سلفنة وأشرطة ستان ملكية للمعارض والمتاجر الراقية.',
                'description' => 'أكياس بوتيكات ومعارض فاخرة مصنوعة من ورق الكوشيه السميك، مع طباعة ملونة وتفاصيل بارزة وشرائط ستان حريرية ناعمة تعكس فخامة المنتجات المحمولة بداخلها.',
                'specifications' => [
                    'الخامة' => 'ورق كوشيه فاخر 250 جرام مدعم بقواعد كرتونية في الأعلى والأسفل',
                    'التشطيب' => 'سلوفان مطفي فاخر (Matte Lamination) + بصمة ذهبية للشعار',
                    'المقابض' => 'شرائط قماشية ستان حريري عريضة بألوان متناسقة',
                    'الحد الأدنى' => '500 كيس',
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
                'name' => 'طباعة كتالوجات وملفات تعريف الشركات (Company Profiles)',
                'slug' => 'corporate-company-profile-catalogues',
                'short_description' => 'كتالوجات وملفات تعريفية احترافية بتجليد فاخر وطباعة ألوان دقيقة تبرز إنجازات شركتك.',
                'description' => 'بروفايلات وكتالوجات تعريفية تعكس المكانة الحقيقية لأعمالك، مع خيارات تجليد متعددة مثل الدبوس، السلك المعدني، أو التجليد الفاخر بالغراء الحراري (Perfect Binding) والكرتون المقوى (Hardcover) مع إضافة السلوفان والبصمة.',
                'specifications' => [
                    'الغلاف' => 'كرتون مقوى 350 جم بسلوفان حراري مطفي + يو في موضعي',
                    'الصفحات الداخلية' => 'ورق كوشيه ألماني مطفي 150 جم',
                    'نوع التجليد' => 'غراء حراري فاخر (Perfect Binding) أو سلك معدني أنيق',
                    'المقاسات' => 'A4 رأسي أو أفقي، A5، ومقاسات مربعة خاصة',
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
                'name' => 'ستيكرات فينيل وقص مخصص مقاومة للماء (Die-Cut)',
                'slug' => 'waterproof-vinyl-die-cut-stickers',
                'short_description' => 'ملصقات فينيل ضد الماء والحرارة مقصوصة بالليزر على حدود التصميم بدقة رقمية فائقة.',
                'description' => 'ستيكرات عالية التحمل ومقاومة للماء والرطوبة وأشعة الشمس والخدش، مثالية للعبوات الزجاجية والبلاستيكية والأجهزة والتغليف بجميع الأشكال الهندسية والقص المخصص وفق هوية علامتك.',
                'specifications' => [
                    'المادة' => 'فينيل بوليمري عالي الجودة (أبيض، شفاف، أو هولوجرام ثلاثي الأبعاد)',
                    'المقاومة' => 'مقاوم للماء، الرطوبة، والحرارة حتى 80 درجة مئوية',
                    'طريقة القص' => 'قص ليزري دقيق على حدود التصميم (Die-Cut / Kiss-Cut)',
                    'طريقة التوريد' => 'قطع مفردة، شيتات مقسمة، أو رولات مخصصة للمكائن',
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
                'name' => 'طقم مطبوعات ورقية ومراسلات رسمية للشركات',
                'slug' => 'complete-corporate-stationery-pack',
                'short_description' => 'باقة متكاملة من الأوراق الرسمية والمظاريف والمجلدات المصممة لتعزيز الحضور المهني.',
                'description' => 'تشكيلة متكاملة من المطبوعات الرسمية والمكتبية للشركات، تشمل أوراق المراسلات والفواتير (Letterhead) المتوافقة مع الطابعات الليزرية، وأظرف المراسلات بأحجامها المتعددة، وفولدرات العقود بجيب داخلي متين لحفظ المستندات وبطاقة العمل.',
                'specifications' => [
                    'ورق المراسلات' => 'ورق وود فري 100 جرام ألماني ناصع البياض ملائم لكافة الطابعات',
                    'المظاريف' => 'مقاس DL للأوراق المطوية ومقاس A4 مع شريط لاصق ذاتي التثبيت',
                    'الفولدرات' => 'كرتون مقوى 350 جرام بسلوفان حماية وجيب داخلي مع شق لكروت العمل',
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
                'name' => 'ستاند رول اب إعلاني مع الطباعة والحقيبة المبطنة',
                'slug' => 'premium-advertising-rollup-stand',
                'short_description' => 'ستاندات رول اب إعلانية سهلة الفك والتركيب والتنقل للمؤتمرات والمعارض والفعاليات.',
                'description' => 'ستاند ألومنيوم متين وقوي خفيف الوزن مع خامة طباعة عالية الجودة غير عاكسة للضوء ومقاومة للالتفاف، مرفق بحقيبة قماشية مبطنة لسهولة الحمل والتنقل في المعارض والفعاليات التسويقية.',
                'specifications' => [
                    'المقاس المتوفر' => '85 × 200 سم / 120 × 200 سم / 150 × 200 سم',
                    'هيكل الستاند' => 'ألومنيوم خفيف الوزن مع أرجل اتزان عريضة وقضيب تثبيت علوي كليبس',
                    'مادة الطباعة' => 'فيلم بولي بروبلين (PP Film) فاخر مانع لانعكاس الإضاءة ومقاوم للتمزق',
                    'الملحقات' => 'حقيبة قماشية مبطنة بحزام كتف لحماية الستاند أثناء التنقل',
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
                'name' => 'دروع كريستالية تذكارية فاخرة مع حفر ليزري',
                'slug' => 'crystal-trophy-awards',
                'short_description' => 'دروع تكريم كريستال نقي بتصميم هندسي راقٍ وحفر ليزري داخلي أو خارجي مع علبة فاخرة.',
                'description' => 'دروع تكريمية فخمة مصنوعة من الكريستال النقي بدرجة نقاء K9، تقدم في مناسبات التكريم، والتخرج، والاحتفالات الرسمية وتكريم الموظفين، مع إمكانية الحفر الليزري المخصص للشعار والنصوص وإضافة ألوان، مرفقة بعلبة هدايا فاخرة.',
                'specifications' => [
                    'الخامة' => 'كريستال بصري K9 عالي النقاوة بلمعان فائق',
                    'تقنية الحفر' => 'حفر ليزر ثلاثي الأبعاد عالي الدقة أو طباعة UV ملونة مقاومة للخدش',
                    'العلبة' => 'علبة هدايا كرتونية فاخرة بقفل مغناطيسي وبطانة حريرية ملكية',
                    'الأبعاد' => 'ارتفاع 22 سم إلى 30 سم بقاعدة سميكة متزنة',
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
                'name' => 'أختام رسمية أوتوماتيكية دائرية ومستطيلة',
                'slug' => 'official-automatic-self-inking-stamps',
                'short_description' => 'أختام رسمية معتمدة بتقنية الحبر الذاتي الأوتوماتيكي وحفر ليزري للمطاط فائق الدقة.',
                'description' => 'أختام رسمية معتمدة للشركات والمؤسسات والعيادات والمكاتب القانونية، حفر ليزري عالي الدقة يضمن وضوح أدق التفاصيل والشعارات المعقدة لآلاف المرات دون الحاجة لإعادة التعبئة.',
                'specifications' => [
                    'النوع' => 'ختم أوتوماتيكي بحبر مدمج ذاتي (Self-Inking)',
                    'الشكل' => 'دائري (قطر 40 مم) أو مستطيل (60 × 25 مم)',
                    'ألوان الحبر' => 'أزرق ملكي، أحمر، أسود، أو أخضر',
                    'عمر الحبر' => 'يكفي لأكثر من 10,000 طبعة مع إمكانية استبدال وسادة الحبر بسهولة',
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
