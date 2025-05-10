@extends('adminlte::page')

@section('title', 'أنواع التأشيرات')

@section('content_header')

    <h1 class="text-success" style="font-weight:bold; text-align:right;"> المهن لتأشيرة برقم صادر (4545454545)</h1>
@stop

@section('content')
    <div class="row">
        <!-- ✅ قسم إضافة مجموعة -->
        <div class="col-md-12 mb-4">
            @if ($visaEdit->profession_count === '')
                <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                    style="border-radius: 15px; background-color: #f8f9fa;">
                    <h4 class="mb-3 text-dark font-weight-bold">إضافة مهنة</h4>
                    <form action="{{ route('visa-profession.create', $visa_id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold"> التصنيف المهني </label>
                                <select class="form-control fw-bold" style="border-color: #997a44;" name="job_title">
                                    <option value="">اختر التصنيف المهني </option>
                                    <option value="المشرعون وكبار المسؤولين" data-select2-id="35">المشرعون وكبار المسؤولين
                                    </option>
                                    <option value="المديرون العامون والرؤساء التنفيذيون" data-select2-id="143">المديرون
                                        العامون والرؤساء التنفيذيون</option>
                                    <option value="مديرو خدمات الأعمال والإدارة" data-select2-id="144">مديرو خدمات الأعمال
                                        والإدارة</option>
                                    <option value="مديرو المبيعات والتسويق والتطوير" data-select2-id="145">مديرو المبيعات
                                        والتسويق والتطوير</option>
                                    <option value="مديرو الإنتاج في الزراعة والغابات والمزارع السمكية"
                                        data-select2-id="146">مديرو الإنتاج في الزراعة والغابات والمزارع السمكية</option>
                                    <option value="مديرو التصنيع والمناجم والإنشاء والتوزيع" data-select2-id="147">مديرو
                                        التصنيع والمناجم والإنشاء والتوزيع</option>
                                    <option value="مديرو خدمات تقنية المعلومات والاتصالات" data-select2-id="148">مديرو خدمات
                                        تقنية المعلومات والاتصالات</option>
                                    <option value="مديرو الخدمات التخصصية" data-select2-id="149">مديرو الخدمات التخصصية
                                    </option>
                                    <option value="مديرو الفنادق والمطاعم" data-select2-id="150">مديرو الفنادق والمطاعم
                                    </option>
                                    <option value="مديرو تجارة الجملة والتجزئة" data-select2-id="151">مديرو تجارة الجملة
                                        والتجزئة</option>
                                    <option value="مديرو الخدمات الأخرى" data-select2-id="152">مديرو الخدمات الأخرى</option>
                                    <option value="الاختصاصيّون في الفيزياء وعلوم الأرض" data-select2-id="153">الاختصاصيّون
                                        في الفيزياء وعلوم الأرض</option>
                                    <option value="الاختصاصيّون في الرياضيات وخبراء التأمين والإحصائيّون"
                                        data-select2-id="154">الاختصاصيّون في الرياضيات وخبراء التأمين والإحصائيّون</option>
                                    <option value="الاختصاصيّون في العلوم الحياتية" data-select2-id="155">الاختصاصيّون في
                                        العلوم الحياتية</option>
                                    <option value="الاختصاصيّون في الهندسة (عدا تقنية الكهرباء)" data-select2-id="156">
                                        الاختصاصيّون في الهندسة (عدا تقنية الكهرباء)</option>
                                    <option value="مهندسو تقنية الكهرباء" data-select2-id="157">مهندسو تقنية الكهرباء
                                    </option>
                                    <option value="المهندسون المعماريّون والمخطّطون والمسّاحون والمصمِمون"
                                        data-select2-id="158">المهندسون المعماريّون والمخطّطون والمسّاحون والمصمِمون
                                    </option>
                                    <option value="الأطباء" data-select2-id="159">الأطباء</option>
                                    <option value="الاختصاصيّون في التمريض والقبالة" data-select2-id="160">الاختصاصيّون في
                                        التمريض والقبالة</option>
                                    <option value="الاختصاصيّون في الطب الشعبي والطب التكميليّ" data-select2-id="161">
                                        الاختصاصيّون في الطب الشعبي والطب التكميليّ</option>
                                    <option value="الاختصاصيون في المساعدات الطبية" data-select2-id="162">الاختصاصيون في
                                        المساعدات الطبية</option>
                                    <option value="الأطباء البيطريّون" data-select2-id="163">الأطباء البيطريّون</option>
                                    <option value="الاختصاصيّون في الصحة الآخرون" data-select2-id="164">الاختصاصيّون في
                                        الصحة الآخرون</option>
                                    <option value="الاختصاصيّون في التعليم الجامعي والتعليم العالي" data-select2-id="165">
                                        الاختصاصيّون في التعليم الجامعي والتعليم العالي</option>
                                    <option value="مدرّسو التعليم المهني" data-select2-id="166">مدرّسو التعليم المهني
                                    </option>
                                    <option value="مدرّسو التعليم الثانوي" data-select2-id="167">مدرّسو التعليم الثانوي
                                    </option>
                                    <option value="اختصاصيو المدارس الابتدائية والطفولة المبكرة" data-select2-id="168">
                                        اختصاصيو المدارس الابتدائية والطفولة المبكرة</option>
                                    <option value="الاختصاصيون في التدريس الآخرون" data-select2-id="169">الاختصاصيون في
                                        التدريس الآخرون</option>
                                    <option value="الاختصاصيّون الماليّون" data-select2-id="170">الاختصاصيّون الماليّون
                                    </option>
                                    <option value="الاختصاصيّون في الإشراف الإداري" data-select2-id="171">الاختصاصيّون في
                                        الإشراف الإداري</option>
                                    <option value="الاختصاصيّون في البيع والتسويق والعلاقات العامة" data-select2-id="172">
                                        الاختصاصيّون في البيع والتسويق والعلاقات العامة</option>
                                    <option value="مطوّرو ومحلّلو البرمجيات والتطبيقات" data-select2-id="173">مطوّرو ومحلّلو
                                        البرمجيات والتطبيقات</option>
                                    <option value="الاختصاصيّون في قواعد البيانات والشبكات" data-select2-id="174">
                                        الاختصاصيّون في قواعد البيانات والشبكات</option>
                                    <option value="الاختصاصيّون في القانون" data-select2-id="175">الاختصاصيّون في القانون
                                    </option>
                                    <option value="أمناء المكتبات والأرشيف والمتاحف" data-select2-id="176">أمناء المكتبات
                                        والأرشيف والمتاحف</option>
                                    <option value="الاختصاصيّون الاجتماعيّون والدينيّون" data-select2-id="177">الاختصاصيّون
                                        الاجتماعيّون والدينيّون</option>
                                    <option value="المؤلّفون والصحفيون واللغويّون" data-select2-id="178">المؤلّفون والصحفيون
                                        واللغويّون</option>
                                    <option value="فنّانو الإبداع والأداء" data-select2-id="179">فنّانو الإبداع والأداء
                                    </option>
                                    <option value="فنيّو العلوم الفيزيائية والهندسية" data-select2-id="180">فنيّو العلوم
                                        الفيزيائية والهندسية</option>
                                    <option value="مشرفو المناجم والتصنيع والإنشاء" data-select2-id="181">مشرفو المناجم
                                        والتصنيع والإنشاء</option>
                                    <option value="فنيّو ضبط العمليات" data-select2-id="182">فنيّو ضبط العمليات</option>
                                    <option value="فنيّو العلوم الحياتية ومن يرتبط بهم من المساعدين الاختصاصين"
                                        data-select2-id="183">فنيّو العلوم الحياتية ومن يرتبط بهم من المساعدين الاختصاصين
                                    </option>
                                    <option value="فنيّو ومراقبو السفن والطائرات" data-select2-id="184">فنيّو ومراقبو
                                        السفن والطائرات</option>
                                    <option value="فنيّو الطب والصيدلة" data-select2-id="185">فنيّو الطب والصيدلة</option>
                                    <option value="الاختصاصيّون المساعدون في التمريض والقبالة" data-select2-id="186">
                                        الاختصاصيّون المساعدون في التمريض والقبالة</option>
                                    <option value="الاختصاصيّون المساعدون في الطب الشعبي والطب التكميلي"
                                        data-select2-id="187">الاختصاصيّون المساعدون في الطب الشعبي والطب التكميلي</option>
                                    <option value="فنيّو ومساعدو الطب البيطري" data-select2-id="188">فنيّو ومساعدو الطب
                                        البيطري</option>
                                    <option value="الاختصاصيّون المساعدون في الصحة الآخرون" data-select2-id="189">
                                        الاختصاصيّون المساعدون في الصحة الآخرون</option>
                                    <option value="الاختصاصيّون المساعدون في العمليات المالية والرياضيات"
                                        data-select2-id="190">الاختصاصيّون المساعدون في العمليات المالية والرياضيات
                                    </option>
                                    <option value="وكلاء ووسطاء البيع والشراء" data-select2-id="191">وكلاء ووسطاء البيع
                                        والشراء</option>
                                    <option value="وكلاء خدمات الأعمال" data-select2-id="192">وكلاء خدمات الأعمال</option>
                                    <option value="السكرتارية الإدارية والمتخصصة" data-select2-id="193">السكرتارية
                                        الإدارية والمتخصصة</option>
                                    <option value="الاختصاصيّون المساعدون في الوكالات الحكومية التنظيمية"
                                        data-select2-id="194">الاختصاصيّون المساعدون في الوكالات الحكومية التنظيمية
                                    </option>
                                    <option value="الاختصاصيّون المساعدون في القانون وعلم الاجتماع والشؤون الدينية"
                                        data-select2-id="195">الاختصاصيّون المساعدون في القانون وعلم الاجتماع والشؤون
                                        الدينية</option>
                                    <option value="العاملون في الرياضة واللياقة البدنية" data-select2-id="196">العاملون في
                                        الرياضة واللياقة البدنية</option>
                                    <option value="الاختصاصيّون المساعدون في الفنون والثقافة والطهي"
                                        data-select2-id="197">الاختصاصيّون المساعدون في الفنون والثقافة والطهي</option>
                                    <option value="فنيّو عمليات ودعم مستخدمي تقنية المعلومات والاتصالات"
                                        data-select2-id="198">فنيّو عمليات ودعم مستخدمي تقنية المعلومات والاتصالات</option>
                                    <option value="فنيّو الاتصالات السلكية واللاسلكية والبث الإذاعي"
                                        data-select2-id="199">فنيّو الاتصالات السلكية واللاسلكية والبث الإذاعي</option>
                                    <option value="الكتبة الإداريّون العامّون" data-select2-id="200">الكتبة الإداريّون
                                        العامّون</option>
                                    <option value="السكرتارية (العامّة)" data-select2-id="201">السكرتارية (العامّة)
                                    </option>
                                    <option value="الطابعون" data-select2-id="202">الطابعون</option>
                                    <option value="الصرّافون ومحصّلو الأموال ومن يرتبط بهم من الكتبة"
                                        data-select2-id="203">الصرّافون ومحصّلو الأموال ومن يرتبط بهم من الكتبة</option>
                                    <option value="العاملون في معلومات العملاء" data-select2-id="204">العاملون في معلومات
                                        العملاء</option>
                                    <option value="الكتبة الرقميون" data-select2-id="205">الكتبة الرقميون</option>
                                    <option value="كتبة تسجيل المواد والنقل" data-select2-id="206">كتبة تسجيل المواد
                                        والنقل</option>
                                    <option value="عاملو الدعم المكتبي الآخرون" data-select2-id="207">عاملو الدعم المكتبي
                                        الآخرون</option>
                                    <option value="مضيفو ومراقبو ومرشدو السفر" data-select2-id="208">مضيفو ومراقبو ومرشدو
                                        السفر</option>
                                    <option value="الطهاة" data-select2-id="209">الطهاة</option>
                                    <option value="النادلون والسقاة" data-select2-id="210">النادلون والسقاة</option>
                                    <option value="مُصفّفو الشعر ومتخصصو التجميل ومن يرتبط بهم" data-select2-id="211">
                                        مُصفّفو الشعر ومتخصصو التجميل ومن يرتبط بهم</option>
                                    <option value="مشرفو المباني والتدبير المنزلي" data-select2-id="212">مشرفو المباني
                                        والتدبير المنزلي</option>
                                    <option value="عاملو الخدمات الشخصية الآخرون" data-select2-id="213">عاملو الخدمات
                                        الشخصية الآخرون</option>
                                    <option value="بائعو الشوارع والأسواق" data-select2-id="214">بائعو الشوارع والأسواق
                                    </option>
                                    <option value="بائعو المتاجر" data-select2-id="215">بائعو المتاجر</option>
                                    <option value="عاملو الكاشير وبائعو التذاكر" data-select2-id="216">عاملو الكاشير
                                        وبائعو التذاكر</option>
                                    <option value="عاملو المبيعات الآخرون" data-select2-id="217">عاملو المبيعات الآخرون
                                    </option>
                                    <option value="العاملون في رعاية الطفل ومساعدو المدرسين" data-select2-id="218">
                                        العاملون في رعاية الطفل ومساعدو المدرسين</option>
                                    <option value="عاملو الرعاية الشخصية في الخدمات الصحية" data-select2-id="219">عاملو
                                        الرعاية الشخصية في الخدمات الصحية</option>
                                    <option value="عاملو خدمات الحماية" data-select2-id="220">عاملو خدمات الحماية</option>
                                    <option value="العاملون في التشجير ومزارعو المحاصيل" data-select2-id="221">العاملون في
                                        التشجير ومزارعو المحاصيل</option>
                                    <option value="عاملو الإنتاج الحيواني" data-select2-id="222">عاملو الإنتاج الحيواني
                                    </option>
                                    <option value="عاملو الإنتاج الزراعي والحيواني المختلط" data-select2-id="223">عاملو
                                        الإنتاج الزراعي والحيواني المختلط</option>
                                    <option value="عاملو زراعة الغابات وما يرتبط بها" data-select2-id="224">عاملو زراعة
                                        الغابات وما يرتبط بها</option>
                                    <option value="عاملو مزارع الأسماك وصائدو الطرائد وناصبو المصائد"
                                        data-select2-id="225">عاملو مزارع الأسماك وصائدو الطرائد وناصبو المصائد</option>
                                    <option value="مزارعو المحاصيل للإعاشة" data-select2-id="226">مزارعو المحاصيل للإعاشة
                                    </option>
                                    <option value="مزارعو المواشي للإعاشة" data-select2-id="227">مزارعو المواشي للإعاشة
                                    </option>
                                    <option value="مزارعو محاصيل متنوعة ومواشي للإعاشة" data-select2-id="228">مزارعو
                                        محاصيل متنوعة ومواشي للإعاشة</option>
                                    <option value="صيادو الأسماك و صائدو الطرائد والجامعون للإعاشة" data-select2-id="229">
                                        صيادو الأسماك و صائدو الطرائد والجامعون للإعاشة</option>
                                    <option value="عاملو هياكل البناء ومن يرتبط بهم من الحرفيين" data-select2-id="230">
                                        عاملو هياكل البناء ومن يرتبط بهم من الحرفيين</option>
                                    <option value="العاملون في تشطيب المباني ومن يرتبط بهم من الحرفيين"
                                        data-select2-id="231">العاملون في تشطيب المباني ومن يرتبط بهم من الحرفيين</option>
                                    <option value="العاملون في الدهان وتنظيف الهياكل الإنشائية ومن يرتبط بهم"
                                        data-select2-id="232">العاملون في الدهان وتنظيف الهياكل الإنشائية ومن يرتبط بهم
                                    </option>
                                    <option
                                        value="العاملون في أشغال الصفيح والهياكل المعدنية وصانعو القوالب واللحّامون ومن يرتبط بهم"
                                        data-select2-id="233">العاملون في أشغال الصفيح والهياكل المعدنية وصانعو القوالب
                                        واللحّامون ومن يرتبط بهم</option>
                                    <option value="الحدّادون وصانعو الأدوات ومن يرتبط بهم من الحرفيين"
                                        data-select2-id="234">الحدّادون وصانعو الأدوات ومن يرتبط بهم من الحرفيين</option>
                                    <option value="ميكانيكيّو ومصلّحو الآلات" data-select2-id="235">ميكانيكيّو ومصلّحو
                                        الآلات</option>
                                    <option value="العاملون الحِرفيّون" data-select2-id="236">العاملون الحِرفيّون</option>
                                    <option value="العاملون في مهن الطباعة" data-select2-id="237">العاملون في مهن الطباعة
                                    </option>
                                    <option value="العاملون في تركيب الأجهزة الكهربائية وتصليحها" data-select2-id="238">
                                        العاملون في تركيب الأجهزة الكهربائية وتصليحها</option>
                                    <option value="العاملون في تركيب الإلكترونيّات وأجهزة الاتصالات وتصليحها"
                                        data-select2-id="239">العاملون في تركيب الإلكترونيّات وأجهزة الاتصالات وتصليحها
                                    </option>
                                    <option value="العاملون في تصنيع المواد الغذائية ومن يرتبط بهم من الحرفيّين"
                                        data-select2-id="240">العاملون في تصنيع المواد الغذائية ومن يرتبط بهم من الحرفيّين
                                    </option>
                                    <option value="معالجو الأخشاب وصانعو الخزائن ومن يرتبط بهم من الحرفيين"
                                        data-select2-id="241">معالجو الأخشاب وصانعو الخزائن ومن يرتبط بهم من الحرفيين
                                    </option>
                                    <option value="العاملون في صناعة الملابس ومن يرتبط بهم من الحِرفيين"
                                        data-select2-id="242">العاملون في صناعة الملابس ومن يرتبط بهم من الحِرفيين</option>
                                    <option value="العاملون الحِرفيّون الآخرون ومن يرتبط بهم" data-select2-id="243">
                                        العاملون الحِرفيّون الآخرون ومن يرتبط بهم</option>
                                    <option value="مشغّلو المناجم ومصانع معالجة المعادن" data-select2-id="244">مشغّلو
                                        المناجم ومصانع معالجة المعادن</option>
                                    <option value="مشغّلو مصانع معالجة وتشطيب المعادن" data-select2-id="245">مشغّلو مصانع
                                        معالجة وتشطيب المعادن</option>
                                    <option
                                        value="مشغّلو مصانع وآلات تصنيع المنتجات الكيميائية ومنتجات التصوير الفوتوغرافي"
                                        data-select2-id="246">مشغّلو مصانع وآلات تصنيع المنتجات الكيميائية ومنتجات التصوير
                                        الفوتوغرافي</option>
                                    <option value="مشغّلو آلات تصنيع المنتجات المطاطية والبلاستيكية والورقية"
                                        data-select2-id="247">مشغّلو آلات تصنيع المنتجات المطاطية والبلاستيكية والورقية
                                    </option>
                                    <option value="مشغّلو آلات تصنيع منتجات النسيج والفراء والجلود" data-select2-id="248">
                                        مشغّلو آلات تصنيع منتجات النسيج والفراء والجلود</option>
                                    <option value="مشغّلو آلات تصنيع المنتجات الغذائية وما يرتبط بها"
                                        data-select2-id="249">مشغّلو آلات تصنيع المنتجات الغذائية وما يرتبط بها</option>
                                    <option value="مشغّلو مصانع معالجة الأخشاب وتصنيع الورق" data-select2-id="250">مشغّلو
                                        مصانع معالجة الأخشاب وتصنيع الورق</option>
                                    <option value="مشغّلو الآلات والمصانع الثابتة الأخرى" data-select2-id="251">مشغّلو
                                        الآلات والمصانع الثابتة الأخرى</option>
                                    <option value="العاملون في التجميع" data-select2-id="252">العاملون في التجميع</option>
                                    <option value="سائقو القاطرات ذات المحرك ومن يرتبط بهم" data-select2-id="253">سائقو
                                        القاطرات ذات المحرك ومن يرتبط بهم</option>
                                    <option value="سائقو المركبات الخاصة والعربات والدراجات النارية"
                                        data-select2-id="254">سائقو المركبات الخاصة والعربات والدراجات النارية</option>
                                    <option value="سائقو الشاحنات الثقيلة والباصات" data-select2-id="103">سائقو الشاحنات
                                        الثقيلة والباصات</option>
                                    <option value="مشغلو آليات المعامل المتنقلة" data-select2-id="255">مشغلو آليات المعامل
                                        المتنقلة</option>
                                    <option value="طاقم العاملين على متن السفن ومن يرتبط بهم" data-select2-id="256">طاقم
                                        العاملين على متن السفن ومن يرتبط بهم</option>
                                    <option value="منظّفو المنازل والفنادق والمكاتب والمساعدون" data-select2-id="257">
                                        منظّفو المنازل والفنادق والمكاتب والمساعدون</option>
                                    <option value="عاملو غسيل السيارات والنوافذ والملابس وعاملو الغسيل اليدوي الآخرون"
                                        data-select2-id="258">عاملو غسيل السيارات والنوافذ والملابس وعاملو الغسيل اليدوي
                                        الآخرون</option>
                                    <option value="عمّال الزراعة والغابات ومزارع الأسماك" data-select2-id="259">عمّال
                                        الزراعة والغابات ومزارع الأسماك</option>
                                    <option value="عمّال التعدين والإنشاء" data-select2-id="260">عمّال التعدين والإنشاء
                                    </option>
                                    <option value="عمّال التصنيع" data-select2-id="261">عمّال التصنيع</option>
                                    <option value="عمّال النقل والتخزين" data-select2-id="262">عمّال النقل والتخزين
                                    </option>
                                    <option value="مساعدو تحضير الأطعمة" data-select2-id="263">مساعدو تحضير الأطعمة
                                    </option>
                                    <option value="العاملون المتجولون ومن يرتبط بهم" data-select2-id="264">العاملون
                                        المتجولون ومن يرتبط بهم</option>
                                    <option value="البائعون المتجولون (باستثناء بائعي الأطعمة)" data-select2-id="265">
                                        البائعون المتجولون (باستثناء بائعي الأطعمة)</option>
                                    <option value="عاملو النفايات" data-select2-id="266">عاملو النفايات</option>
                                    <option value="العاملون في المهن الأولية الآخرون" data-select2-id="267">العاملون في
                                        المهن الأولية الآخرون</option>
                                    <option value="" data-select2-id="58">اختر</option>

                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold"> المهنة </label>
                                <select class="form-control fw-bold" style="border-color: #997a44;" name="job">
                                    <option value="">اختر المهنة بالتأشيرة</option>
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job }}">{{ $job }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold"> المجموعة </label>
                                <select class="form-control fw-bold" style="border-color: #997a44;"
                                    name="customer_group_id">
                                    <option value="">اختر المجموعة</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold"> العدد لهذه المهنة </label>
                                <input type="text" class="form-control" name="profession_count"
                                    placeholder="أدخل العدد" required>
                            </div>
                        </div>
                        <!-- زر بعرض كامل -->
                        <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                            style="background-color: #997a44; color: white;">
                            إضافة مهنة للتأشيرة
                        </button>
                    </form>
                </div>
            @else
                <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                    style="border-radius: 15px; background-color: #f8f9fa;">
                    <h4 class="mb-3 text-dark font-weight-bold"> التعديل علي "{{ $visaEdit->job }}"</h4>
                    <form action="{{ route('visa-profession.edit', $visaEdit->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold"> التصنيف المهني </label>
                                <select class="form-control fw-bold" style="border-color: #997a44;" name="job_title">
                                    <option value="">اختر التصنيف المهني </option>
                                    <option value="المشرعون وكبار المسؤولين"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'المشرعون وكبار المسؤولين' ? 'selected' : '' }}>
                                        المشرعون وكبار المسؤولين
                                    </option>
                                    <option value="المديرون العامون والرؤساء التنفيذيون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'المديرون العامون والرؤساء التنفيذيون' ? 'selected' : '' }}>
                                        المديرون العامون والرؤساء التنفيذيون
                                    </option>
                                    <option value="مديرو خدمات الأعمال والإدارة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مديرو خدمات الأعمال والإدارة' ? 'selected' : '' }}>
                                        مديرو خدمات الأعمال والإدارة
                                    </option>
                                    <option value="مديرو المبيعات والتسويق والتطوير"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مديرو المبيعات والتسويق والتطوير' ? 'selected' : '' }}>
                                        مديرو المبيعات والتسويق والتطوير
                                    </option>
                                    <option value="مديرو الإنتاج في الزراعة والغابات والمزارع السمكية"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مديرو الإنتاج في الزراعة والغابات والمزارع السمكية' ? 'selected' : '' }}>
                                        مديرو الإنتاج في الزراعة والغابات والمزارع السمكية
                                    </option>
                                    <option value="مديرو التصنيع والمناجم والإنشاء والتوزيع"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مديرو التصنيع والمناجم والإنشاء والتوزيع' ? 'selected' : '' }}>
                                        مديرو التصنيع والمناجم والإنشاء والتوزيع
                                    </option>
                                    <option value="مديرو خدمات تقنية المعلومات والاتصالات"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مديرو خدمات تقنية المعلومات والاتصالات' ? 'selected' : '' }}>
                                        مديرو خدمات تقنية المعلومات والاتصالات
                                    </option>
                                    <option value="مديرو الخدمات التخصصية"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مديرو الخدمات التخصصية' ? 'selected' : '' }}>
                                        مديرو الخدمات التخصصية
                                    </option>
                                    <option value="مديرو الفنادق والمطاعم"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مديرو الفنادق والمطاعم' ? 'selected' : '' }}>
                                        مديرو الفنادق والمطاعم
                                    </option>
                                    <option value="مديرو تجارة الجملة والتجزئة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مديرو تجارة الجملة والتجزئة' ? 'selected' : '' }}>
                                        مديرو تجارة الجملة والتجزئة
                                    </option>
                                    <option value="مديرو الخدمات الأخرى"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مديرو الخدمات الأخرى' ? 'selected' : '' }}>
                                        مديرو الخدمات الأخرى
                                    </option>
                                    <option value="الاختصاصيّون في الفيزياء وعلوم الأرض"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون في الفيزياء وعلوم الأرض' ? 'selected' : '' }}>
                                        الاختصاصيّون في الفيزياء وعلوم الأرض
                                    </option>
                                    <option value="الاختصاصيّون في الرياضيات وخبراء التأمين والإحصائيّون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون في الرياضيات وخبراء التأمين والإحصائيّون' ? 'selected' : '' }}>
                                        الاختصاصيّون في الرياضيات وخبراء التأمين والإحصائيّون
                                    </option>
                                    <option value="الاختصاصيّون في العلوم الحياتية"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون في العلوم الحياتية' ? 'selected' : '' }}>
                                        الاختصاصيّون في العلوم الحياتية
                                    </option>
                                    <option value="الاختصاصيّون في الهندسة (عدا تقنية الكهرباء)"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون في الهندسة (عدا تقنية الكهرباء)' ? 'selected' : '' }}>
                                        الاختصاصيّون في الهندسة (عدا تقنية الكهرباء)
                                    </option>
                                    <option value="مهندسو تقنية الكهرباء"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مهندسو تقنية الكهرباء' ? 'selected' : '' }}>
                                        مهندسو تقنية الكهرباء
                                    </option>
                                    <option value="المهندسون المعماريّون والمخطّطون والمسّاحون والمصمِمون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'المهندسون المعماريّون والمخطّطون والمسّاحون والمصمِمون' ? 'selected' : '' }}>
                                        المهندسون المعماريّون والمخطّطون والمسّاحون والمصمِمون
                                    </option>
                                    <option value="الأطباء"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الأطباء' ? 'selected' : '' }}>
                                        الأطباء
                                    </option>
                                    <option value="الاختصاصيّون في التمريض والقبالة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون في التمريض والقبالة' ? 'selected' : '' }}>
                                        الاختصاصيّون في التمريض والقبالة
                                    </option>
                                    <option value="الاختصاصيّون في الطب الشعبي والطب التكميليّ"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون في الطب الشعبي والطب التكميليّ' ? 'selected' : '' }}>
                                        الاختصاصيّون في الطب الشعبي والطب التكميليّ
                                    </option>
                                    <option value="الاختصاصيون في المساعدات الطبية"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيون في المساعدات الطبية' ? 'selected' : '' }}>
                                        الاختصاصيون في المساعدات الطبية
                                    </option>
                                    <option value="الأطباء البيطريّون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الأطباء البيطريّون' ? 'selected' : '' }}>
                                        الأطباء البيطريّون
                                    </option>
                                    <option value="الاختصاصيّون في الصحة الآخرون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون في الصحة الآخرون' ? 'selected' : '' }}>
                                        الاختصاصيّون في الصحة الآخرون
                                    </option>
                                    <option value="الاختصاصيّون في التعليم الجامعي والتعليم العالي"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون في التعليم الجامعي والتعليم العالي' ? 'selected' : '' }}>
                                        الاختصاصيّون في التعليم الجامعي والتعليم العالي
                                    </option>
                                    <option value="مدرّسو التعليم المهني"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مدرّسو التعليم المهني' ? 'selected' : '' }}>
                                        مدرّسو التعليم المهني
                                    </option>
                                    <option value="مدرّسو التعليم الثانوي"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مدرّسو التعليم الثانوي' ? 'selected' : '' }}>
                                        مدرّسو التعليم الثانوي
                                    </option>
                                    <option value="اختصاصيو المدارس الابتدائية والطفولة المبكرة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'اختصاصيو المدارس الابتدائية والطفولة المبكرة' ? 'selected' : '' }}>
                                        اختصاصيو المدارس الابتدائية والطفولة المبكرة
                                    </option>
                                    <option value="الاختصاصيون في التدريس الآخرون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيون في التدريس الآخرون' ? 'selected' : '' }}>
                                        الاختصاصيون في التدريس الآخرون
                                    </option>
                                    <option value="الاختصاصيّون الماليّون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون الماليّون' ? 'selected' : '' }}>
                                        الاختصاصيّون الماليّون
                                    </option>
                                    <option value="الاختصاصيّون في الإشراف الإداري"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون في الإشراف الإداري' ? 'selected' : '' }}>
                                        الاختصاصيّون في الإشراف الإداري
                                    </option>
                                    <option value="الاختصاصيّون في البيع والتسويق والعلاقات العامة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون في البيع والتسويق والعلاقات العامة' ? 'selected' : '' }}>
                                        الاختصاصيّون في البيع والتسويق والعلاقات العامة
                                    </option>
                                    <option value="مطوّرو ومحلّلو البرمجيات والتطبيقات"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مطوّرو ومحلّلو البرمجيات والتطبيقات' ? 'selected' : '' }}>
                                        مطوّرو ومحلّلو البرمجيات والتطبيقات
                                    </option>
                                    <option value="الاختصاصيّون في قواعد البيانات والشبكات"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون في قواعد البيانات والشبكات' ? 'selected' : '' }}>
                                        الاختصاصيّون في قواعد البيانات والشبكات
                                    </option>
                                    <option value="الاختصاصيّون في القانون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون في القانون' ? 'selected' : '' }}>
                                        الاختصاصيّون في القانون
                                    </option>
                                    <option value="أمناء المكتبات والأرشيف والمتاحف"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'أمناء المكتبات والأرشيف والمتاحف' ? 'selected' : '' }}>
                                        أمناء المكتبات والأرشيف والمتاحف
                                    </option>
                                    <option value="الاختصاصيّون الاجتماعيّون والدينيّون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون الاجتماعيّون والدينيّون' ? 'selected' : '' }}>
                                        الاختصاصيّون الاجتماعيّون والدينيّون
                                    </option>
                                    <option value="المؤلّفون والصحفيون واللغويّون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'المؤلّفون والصحفيون واللغويّون' ? 'selected' : '' }}>
                                        المؤلّفون والصحفيون واللغويّون
                                    </option>
                                    <option value="فنّانو الإبداع والأداء"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'فنّانو الإبداع والأداء' ? 'selected' : '' }}>
                                        فنّانو الإبداع والأداء
                                    </option>
                                    <option value="فنيّو العلوم الفيزيائية والهندسية"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'فنيّو العلوم الفيزيائية والهندسية' ? 'selected' : '' }}>
                                        فنيّو العلوم الفيزيائية والهندسية
                                    </option>
                                    <option value="مشرفو المناجم والتصنيع والإنشاء"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مشرفو المناجم والتصنيع والإنشاء' ? 'selected' : '' }}>
                                        مشرفو المناجم والتصنيع والإنشاء
                                    </option>
                                    <option value="فنيّو ضبط العمليات"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'فنيّو ضبط العمليات' ? 'selected' : '' }}>
                                        فنيّو ضبط العمليات
                                    </option>
                                    <option value="فنيّو العلوم الحياتية ومن يرتبط بهم من المساعدين الاختصاصين"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'فنيّو العلوم الحياتية ومن يرتبط بهم من المساعدين الاختصاصين' ? 'selected' : '' }}>
                                        فنيّو العلوم الحياتية ومن يرتبط بهم من المساعدين الاختصاصين
                                    </option>
                                    <option value="فنيّو ومراقبو السفن والطائرات"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'فنيّو ومراقبو السفن والطائرات' ? 'selected' : '' }}>
                                        فنيّو ومراقبو السفن والطائرات
                                    </option>
                                    <option value="فنيّو الطب والصيدلة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'فنيّو الطب والصيدلة' ? 'selected' : '' }}>
                                        فنيّو الطب والصيدلة
                                    </option>
                                    <option value="الاختصاصيّون المساعدون في التمريض والقبالة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون المساعدون في التمريض والقبالة' ? 'selected' : '' }}>
                                        الاختصاصيّون المساعدون في التمريض والقبالة
                                    </option>
                                    <option value="الاختصاصيّون المساعدون في الطب الشعبي والطب التكميلي"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون المساعدون في الطب الشعبي والطب التكميلي' ? 'selected' : '' }}>
                                        الاختصاصيّون المساعدون في الطب الشعبي والطب التكميلي
                                    </option>
                                    <option value="فنيّو ومساعدو الطب البيطري"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'فنيّو ومساعدو الطب البيطري' ? 'selected' : '' }}>
                                        فنيّو ومساعدو الطب البيطري
                                    </option>
                                    <option value="الاختصاصيّون المساعدون في الصحة الآخرون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون المساعدون في الصحة الآخرون' ? 'selected' : '' }}>
                                        الاختصاصيّون المساعدون في الصحة الآخرون
                                    </option>
                                    <option value="الاختصاصيّون المساعدون في العمليات المالية والرياضيات"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون المساعدون في العمليات المالية والرياضيات' ? 'selected' : '' }}>
                                        الاختصاصيّون المساعدون في العمليات المالية والرياضيات
                                    </option>
                                    <option value="وكلاء ووسطاء البيع والشراء"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'وكلاء ووسطاء البيع والشراء' ? 'selected' : '' }}>
                                        وكلاء ووسطاء البيع والشراء
                                    </option>
                                    <option value="وكلاء خدمات الأعمال"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'وكلاء خدمات الأعمال' ? 'selected' : '' }}>
                                        وكلاء خدمات الأعمال
                                    </option>
                                    <option value="السكرتارية الإدارية والمتخصصة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'السكرتارية الإدارية والمتخصصة' ? 'selected' : '' }}>
                                        السكرتارية الإدارية والمتخصصة
                                    </option>
                                    <option value="الاختصاصيّون المساعدون في الوكالات الحكومية التنظيمية"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون المساعدون في الوكالات الحكومية التنظيمية' ? 'selected' : '' }}>
                                        الاختصاصيّون المساعدون في الوكالات الحكومية التنظيمية
                                    </option>
                                    <option value="الاختصاصيّون المساعدون في القانون وعلم الاجتماع والشؤون الدينية"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون المساعدون في القانون وعلم الاجتماع والشؤون الدينية' ? 'selected' : '' }}>
                                        الاختصاصيّون المساعدون في القانون وعلم الاجتماع والشؤون الدينية
                                    </option>
                                    <option value="العاملون في الرياضة واللياقة البدنية"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون في الرياضة واللياقة البدنية' ? 'selected' : '' }}>
                                        العاملون في الرياضة واللياقة البدنية
                                    </option>
                                    <option value="الاختصاصيّون المساعدون في الفنون والثقافة والطهي"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الاختصاصيّون المساعدون في الفنون والثقافة والطهي' ? 'selected' : '' }}>
                                        الاختصاصيّون المساعدون في الفنون والثقافة والطهي
                                    </option>
                                    <option value="فنيّو عمليات ودعم مستخدمي تقنية المعلومات والاتصالات"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'فنيّو عمليات ودعم مستخدمي تقنية المعلومات والاتصالات' ? 'selected' : '' }}>
                                        فنيّو عمليات ودعم مستخدمي تقنية المعلومات والاتصالات
                                    </option>
                                    <option value="فنيّو الاتصالات السلكية واللاسلكية والبث الإذاعي"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'فنيّو الاتصالات السلكية واللاسلكية والبث الإذاعي' ? 'selected' : '' }}>
                                        فنيّو الاتصالات السلكية واللاسلكية والبث الإذاعي
                                    </option>
                                    <option value="الكتبة الإداريّون العامّون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الكتبة الإداريّون العامّون' ? 'selected' : '' }}>
                                        الكتبة الإداريّون العامّون
                                    </option>
                                    <option value="السكرتارية (العامّة)"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'السكرتارية (العامّة)' ? 'selected' : '' }}>
                                        السكرتارية (العامّة)
                                    </option>
                                    <option value="الطابعون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الطابعون' ? 'selected' : '' }}>
                                        الطابعون
                                    </option>
                                    <option value="الصرّافون ومحصّلو الأموال ومن يرتبط بهم من الكتبة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الصرّافون ومحصّلو الأموال ومن يرتبط بهم من الكتبة' ? 'selected' : '' }}>
                                        الصرّافون ومحصّلو الأموال ومن يرتبط بهم من الكتبة
                                    </option>
                                    <option value="العاملون في معلومات العملاء"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون في معلومات العملاء' ? 'selected' : '' }}>
                                        العاملون في معلومات العملاء
                                    </option>
                                    <option value="الكتبة الرقميون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الكتبة الرقميون' ? 'selected' : '' }}>
                                        الكتبة الرقميون
                                    </option>
                                    <option value="كتبة تسجيل المواد والنقل"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'كتبة تسجيل المواد والنقل' ? 'selected' : '' }}>
                                        كتبة تسجيل المواد والنقل
                                    </option>
                                    <option value="عاملو الدعم المكتبي الآخرون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'عاملو الدعم المكتبي الآخرون' ? 'selected' : '' }}>
                                        عاملو الدعم المكتبي الآخرون
                                    </option>
                                    <option value="مضيفو ومراقبو ومرشدو السفر"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مضيفو ومراقبو ومرشدو السفر' ? 'selected' : '' }}>
                                        مضيفو ومراقبو ومرشدو السفر
                                    </option>
                                    <option value="الطهاة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الطهاة' ? 'selected' : '' }}>
                                        الطهاة
                                    </option>
                                    <option value="النادلون والسقاة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'النادلون والسقاة' ? 'selected' : '' }}>
                                        النادلون والسقاة
                                    </option>
                                    <option value="مُصفّفو الشعر ومتخصصو التجميل ومن يرتبط بهم"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مُصفّفو الشعر ومتخصصو التجميل ومن يرتبط بهم' ? 'selected' : '' }}>
                                        مُصفّفو الشعر ومتخصصو التجميل ومن يرتبط بهم
                                    </option>
                                    <option value="مشرفو المباني والتدبير المنزلي"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مشرفو المباني والتدبير المنزلي' ? 'selected' : '' }}>
                                        مشرفو المباني والتدبير المنزلي
                                    </option>
                                    <option value="عاملو الخدمات الشخصية الآخرون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'عاملو الخدمات الشخصية الآخرون' ? 'selected' : '' }}>
                                        عاملو الخدمات الشخصية الآخرون
                                    </option>
                                    <option value="بائعو الشوارع والأسواق"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'بائعو الشوارع والأسواق' ? 'selected' : '' }}>
                                        بائعو الشوارع والأسواق
                                    </option>
                                    <option value="بائعو المتاجر"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'بائعو المتاجر' ? 'selected' : '' }}>
                                        بائعو المتاجر
                                    </option>
                                    <option value="عاملو الكاشير وبائعو التذاكر"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'عاملو الكاشير وبائعو التذاكر' ? 'selected' : '' }}>
                                        عاملو الكاشير وبائعو التذاكر
                                    </option>
                                    <option value="عاملو المبيعات الآخرون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'عاملو المبيعات الآخرون' ? 'selected' : '' }}>
                                        عاملو المبيعات الآخرون
                                    </option>
                                    <option value="العاملون في رعاية الطفل ومساعدو المدرسين"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون في رعاية الطفل ومساعدو المدرسين' ? 'selected' : '' }}>
                                        العاملون في رعاية الطفل ومساعدو المدرسين
                                    </option>
                                    <option value="عاملو الرعاية الشخصية في الخدمات الصحية"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'عاملو الرعاية الشخصية في الخدمات الصحية' ? 'selected' : '' }}>
                                        عاملو الرعاية الشخصية في الخدمات الصحية
                                    </option>
                                    <option value="عاملو خدمات الحماية"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'عاملو خدمات الحماية' ? 'selected' : '' }}>
                                        عاملو خدمات الحماية
                                    </option>
                                    <option value="العاملون في التشجير ومزارعو المحاصيل"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون في التشجير ومزارعو المحاصيل' ? 'selected' : '' }}>
                                        العاملون في التشجير ومزارعو المحاصيل
                                    </option>
                                    <option value="عاملو الإنتاج الحيواني"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'عاملو الإنتاج الحيواني' ? 'selected' : '' }}>
                                        عاملو الإنتاج الحيواني
                                    </option>
                                    <option value="عاملو الإنتاج الزراعي والحيواني المختلط"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'عاملو الإنتاج الزراعي والحيواني المختلط' ? 'selected' : '' }}>
                                        عاملو الإنتاج الزراعي والحيواني المختلط
                                    </option>
                                    <option value="عاملو زراعة الغابات وما يرتبط بها"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'عاملو زراعة الغابات وما يرتبط بها' ? 'selected' : '' }}>
                                        عاملو زراعة الغابات وما يرتبط بها
                                    </option>
                                    <option value="عاملو مزارع الأسماك وصائدو الطرائد وناصبو المصائد"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'عاملو مزارع الأسماك وصائدو الطرائد وناصبو المصائد' ? 'selected' : '' }}>
                                        عاملو مزارع الأسماك وصائدو الطرائد وناصبو المصائد
                                    </option>
                                    <option value="مزارعو المحاصيل للإعاشة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مزارعو المحاصيل للإعاشة' ? 'selected' : '' }}>
                                        مزارعو المحاصيل للإعاشة
                                    </option>
                                    <option value="مزارعو المواشي للإعاشة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مزارعو المواشي للإعاشة' ? 'selected' : '' }}>
                                        مزارعو المواشي للإعاشة
                                    </option>
                                    <option value="مزارعو محاصيل متنوعة ومواشي للإعاشة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'مزارعو محاصيل متنوعة ومواشي للإعاشة' ? 'selected' : '' }}>
                                        مزارعو محاصيل متنوعة ومواشي للإعاشة
                                    </option>
                                    <option value="صيادو الأسماك و صائدو الطرائد والجامعون للإعاشة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'صيادو الأسماك و صائدو الطرائد والجامعون للإعاشة' ? 'selected' : '' }}>
                                        صيادو الأسماك و صائدو الطرائد والجامعون للإعاشة
                                    </option>
                                    <option value="عاملو هياكل البناء ومن يرتبط بهم من الحرفيين"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'عاملو هياكل البناء ومن يرتبط بهم من الحرفيين' ? 'selected' : '' }}>
                                        عاملو هياكل البناء ومن يرتبط بهم من الحرفيين
                                    </option>
                                    <option value="العاملون في تشطيب المباني ومن يرتبط بهم من الحرفيين"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون في تشطيب المباني ومن يرتبط بهم من الحرفيين' ? 'selected' : '' }}>
                                        العاملون في تشطيب المباني ومن يرتبط بهم من الحرفيين
                                    </option>
                                    <option value="العاملون في الدهان وتنظيف الهياكل الإنشائية ومن يرتبط بهم"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون في الدهان وتنظيف الهياكل الإنشائية ومن يرتبط بهم' ? 'selected' : '' }}>
                                        العاملون في الدهان وتنظيف الهياكل الإنشائية ومن يرتبط بهم
                                    </option>
                                    <option
                                        value="العاملون في أشغال الصفيح والهياكل المعدنية وصانعو القوالب واللحّامون ومن يرتبط بهم"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون في أشغال الصفيح والهياكل المعدنية وصانعو القوالب واللحّامون ومن يرتبط بهم' ? 'selected' : '' }}>
                                        العاملون في أشغال الصفيح والهياكل المعدنية وصانعو القوالب واللحّامون ومن يرتبط بهم
                                    </option>
                                    <option value="الحدّادون وصانعو الأدوات ومن يرتبط بهم من الحرفيين"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'الحدّادون وصانعو الأدوات ومن يرتبط بهم من الحرفيين' ? 'selected' : '' }}>
                                        الحدّادون وصانعو الأدوات ومن يرتبط بهم من الحرفيين
                                    </option>
                                    <option value="ميكانيكيّو ومصلّحو الآلات"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'ميكانيكيّو ومصلّحو الآلات' ? 'selected' : '' }}>
                                        ميكانيكيّو ومصلّحو الآلات
                                    </option>
                                    <option value="العاملون الحِرفيّون"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون الحِرفيّون' ? 'selected' : '' }}>
                                        العاملون الحِرفيّون
                                    </option>
                                    <option value="العاملون في مهن الطباعة"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون في مهن الطباعة' ? 'selected' : '' }}>
                                        العاملون في مهن الطباعة
                                    </option>
                                    <option value="العاملون في تركيب الأجهزة الكهربائية وتصليحها"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون في تركيب الأجهزة الكهربائية وتصليحها' ? 'selected' : '' }}>
                                        العاملون في تركيب الأجهزة الكهربائية وتصليحها
                                    </option>
                                    <option value="العاملون في تركيب الإلكترونيّات وأجهزة الاتصالات وتصليحها"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون في تركيب الإلكترونيّات وأجهزة الاتصالات وتصليحها' ? 'selected' : '' }}>
                                        العاملون في تركيب الإلكترونيّات وأجهزة الاتصالات وتصليحها
                                    </option>
                                    <option value="العاملون في تصنيع المواد الغذائية ومن يرتبط بهم من الحرفيّين"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون في تصنيع المواد الغذائية ومن يرتبط بهم من الحرفيّين' ? 'selected' : '' }}>
                                        العاملون في تصنيع المواد الغذائية ومن يرتبط بهم من الحرفيّين
                                    </option>
                                    <option value="معالجو الأخشاب وصانعو الخزائن ومن يرتبط بهم من الحرفيين"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'معالجو الأخشاب وصانعو الخزائن ومن يرتبط بهم من الحرفيين' ? 'selected' : '' }}>
                                        معالجو الأخشاب وصانعو الخزائن ومن يرتبط بهم من الحرفيين
                                    </option>
                                    <option value="العاملون في صناعة الملابس ومن يرتبط بهم من الحِرفيين"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون في صناعة الملابس ومن يرتبط بهم من الحِرفيين' ? 'selected' : '' }}>
                                        العاملون في صناعة الملابس ومن يرتبط بهم من الحِرفيين
                                    </option>
                                    <option value="العاملون الحِرفيّون الآخرون ومن يرتبط بهم"
                                        {{ old('job_title', $visaEdit->job_title ?? '') == 'العاملون الحِرفيّون الآخرون ومن يرتبط بهم' ? 'selected' : '' }}>
                                        العاملون الحِرفيّون الآخرون ومن يرتبط بهم
                                    </option>

                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold"> المجموعة </label>
                                <select class="form-control fw-bold" style="border-color: #997a44;"
                                    name="customer_group_id">
                                    <option value="">اختر المجموعة</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}"
                                            {{ old('customer_group_id', $visaEdit->customer_group_id ?? '') == $group->id ? 'selected' : '' }}>
                                            {{ $group->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">

                                <label class="font-weight-bold"> المهنة </label>
                                <select class="form-control fw-bold" style="border-color: #997a44;" name="job"
                                    required>
                                    <option value="">اختر المهنة بالتأشيرة</option>
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job }}"
                                            {{ $visaEdit->job == $job ? 'selected' : '' }}>
                                            {{ $job }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold"> العدد لهذه المهنة </label>
                                <input type="text" class="form-control" name="profession_count"
                                    value="{{ $visaEdit->profession_count }}" placeholder="أدخل العدد" required>
                            </div>
                        </div>
                        <!-- زر بعرض كامل -->
                        <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                            style="background-color: #997a44; color: white;">
                            حفظ التعديلات
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- ✅ قسم البحث والعرض -->
        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                style="border-radius: 15px; background-color: #eae0d5;">
                <h4 class="mb-3 text-dark font-weight-bold">
                    قائمة المهن
                </h4>

                <!-- 🔎 مربع البحث والفلترة -->
                <div class="row mb-3">

                    <div class="col-md-6">
                        <select id="filterType" class="form-control" onchange="searchTable()">
                            <option value="all"> البحث في جميع الحقول</option>
                            <option value="id"> كود مدةالتأشيرة</option>
                            <option value="name"> مدة التأشيرة</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="searchInput" class="form-control" placeholder=" أدخل كلمة البحث..."
                            onkeyup="searchTable()">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-center animate__animated animate__fadeInUp" id="delegatesTable">
                        <thead class="text-white"
                            style="background: linear-gradient(45deg, #997a44, #7c6232); border-radius: 10px;">
                            <tr>
                                <th> التصنيف المهني </th>
                                <th> المهنة </th>
                                <th> العدد </th>
                                <th> المجموعة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visas as $visa)
                                <tr class="table-light">
                                    <td>{{ $visa->job_title }}</td>
                                    <td>{{ $visa->job }}</td>
                                    <td class="highlight"> <span class="badge bg-info">
                                            {{ $visa->profession_count }}</span>
                                    </td>
                                    <td>{{ $visa->customerGroup->title }}</td>

                                    <td>
                                        <a href="{{ route('visa-profession.index', [$visa_id, $visa->id]) }}">
                                            <button class="btn btn-sm btn-outline-success shadow-sms">
                                                <i class="fas fa-edit"></i> تعديل
                                            </button>
                                        </a>
                                        <form action="{{ route('visa-profession.delete', $visa->id) }}" method="POST"
                                            class="mx-1" onsubmit="confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger shadow-sm" type="submit">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> اضافة مهن للتأشيرة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">اغلاق</button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 form-group">
                        <label class="font-weight-bold"> المهنة بالتأشيرة </label>
                        <input type="text" class="form-control" name="name" placeholder="أدخل اسم المهنة"
                            required>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-center animate__animated animate__fadeInUp" id="delegatesTable">
                        <thead class="text-white"
                            style="background: linear-gradient(45deg, #997a44, #7c6232); border-radius: 10px;">
                            <tr>
                                <th> المهنة بالتأشيرة </th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-light">
                                <td>سائق حافلة</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success shadow-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="btn btn-sm btn-outline-danger shadow-sm" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal"><i class="fas fa-trash"></i> حذف</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="background: linear-gradient(45deg, #997a44, #7c6232); border-radius: 10px;">اضافة</button>
                </div>
            </div>
            @if (Session::has('error'))
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "خطأ...",
                        text: "{{ Session::get('error') }}",
                    });
                </script>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        /* ✅ تحسين إدخال البيانات */
        .form-control {
            border-radius: 10px;
            padding: 12px;
            height: 50px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #997a44;
            box-shadow: 0 0 8px rgba(153, 122, 68, 0.3);
        }

        /* ✅ تحسين الجدول */
        .table-hover tbody tr:hover {
            background-color: #f1ede5;
            transition: 0.3s ease-in-out;
        }

        /* ✅ تحسين الأزرار */
        .btn {
            transition: all 0.3s ease-in-out;
            font-weight: bold;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* ✅ تحسين تقسيم الأقسام */
        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        // ✅ كود البحث داخل الجدول
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("delegatesTable");
            let rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                let rowData = rows[i].getElementsByTagName("td");
                let found = false;
                for (let j = 0; j < rowData.length - 1; j++) {
                    if (rowData[j].textContent.toLowerCase().includes(input)) {
                        found = true;
                        break;
                    }
                }
                rows[i].style.display = found ? "" : "none";
            }
        }
    </script>
@stop
