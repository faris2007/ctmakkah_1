<?php if($STEP==1): ?>
    <form method="post">
        <input type="hidden" name="step" value="1" />
        <table class="tbl" style="width: 50%;margin-top: 15px;">
            <thead>
                <tr>
                    <td colspan="2"><?=@$this->lang->line('register_checkID');?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=@$this->lang->line('login_ID');?></td>
                    <td><input type="text" placeholder="ID .." name="ID" id="ID" maxlength="10" /></td>
                </tr>
                <tr>
                    <td><?=@$this->lang->line('register_expiry_date');?></td>
                    <td><input type="text" placeholder="DD/MM/YYYY" name="expiry" id="expiry" maxlength="10" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="<?=$this->lang->line('register_step1');?>" /></td>
                </tr>
                <?php if($ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('login_error');?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
<?php elseif($STEP == 2): ?>
    <form method="post">
        <input type="hidden" name="step" value="2" />
        <input type="hidden" name="ID" value="<?=@$ID?>" />
        <input type="hidden" name="expiry" value="<?=@$expiry?>" />
        <table class="tbl" style="width: 50%;margin-top: 15px;">
            <thead>
                <tr>
                    <td colspan="2"><?=@$this->lang->line('register_complete_data');?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=@$this->lang->line('register_name_arabic');?></td>
                    <td><input type="text" placeholder="Your Name (Arabic)" name="arName" id="arName" /></td>
                </tr>
                <tr>
                    <td><?=@$this->lang->line('register_name_english');?></td>
                    <td><input type="text" placeholder="Your Name (English)" name="enName" id="enName" /></td>
                </tr>
                <tr>
                    <td><?=@$this->lang->line('register_nationality')?></td>
                    <td>
                        <select name="nationality" id="nationality">
                            <option disabled="true">اختيار الجنسية</option>
                            <option selected="selected" value="1">المملكة العربية السعودية</option>
                            <option value="2">الإمارات  العربية</option>
                            <option value="3">الأردن</option>
                            <option value="4">البحرين</option>
                            <option value="5">سوريا</option>
                            <option value="6">العراق</option>
                            <option value="7">عمان</option>
                            <option value="8">فلسطين</option>
                            <option value="9">قطر</option>
                            <option value="10">الكويت</option>
                            <option value="11">لبنان</option>
                            <option value="12">اليمن</option>
                            <option value="32">تونس</option>
                            <option value="33">الجزائر</option>
                            <option value="34">جيبوتى</option>
                            <option value="35">السودان</option>
                            <option value="36">الصومال</option>
                            <option value="37">ليبيا</option>
                            <option value="38">مصر</option>
                            <option value="39">المغرب</option>
                            <option value="40">موريتانيا</option>
                            <option value="41">افغانستان</option>
                            <option value="42">اندونيسيا</option>
                            <option value="43">ايران</option>
                            <option value="44">باكستان</option>
                            <option value="45">بنجلاديش</option>
                            <option value="46">بروني</option>
                            <option value="47">ميانمار</option>
                            <option value="48">تايلند</option>
                            <option value="49">تركيا</option>
                            <option value="50">جزر مالديف</option>
                            <option value="51">روسيا الإتحادية</option>
                            <option value="52">سنغافورة</option>
                            <option value="53">سري لنكا</option>
                            <option value="54">الصين الوطنية</option>
                            <option value="55">الفلبين</option>
                            <option value="56">فيتنام</option>
                            <option value="57">كمبوديا</option>
                            <option value="58">كوريا الجنوبية</option>
                            <option value="59">ماليزيا</option>
                            <option value="60">نيبال</option>
                            <option value="61">الهند</option>
                            <option value="62">هونج كونج</option>
                            <option value="63">اليابان</option>
                            <option value="64">بهوتان</option>
                            <option value="65">الصين الشعبية</option>
                            <option value="66">قبرص</option>
                            <option value="67">كوريا الشمالية</option>
                            <option value="69">منغوليا</option>
                            <option value="70">ماكاو</option>
                            <option value="71">تركستان</option>
                            <option value="73">بخارستان</option>
                            <option value="75">كازاخستان</option>
                            <option value="76">ازبكستان</option>
                            <option value="77">تركمانستان</option>
                            <option value="78">طاجكستان</option>
                            <option value="79">قيرغيزيا</option>
                            <option value="82">اذربيجان</option>
                            <option value="83">الشاشان</option>
                            <option value="84">داغستان</option>
                            <option value="85">انقوش</option>
                            <option value="86">تتارستان</option>
                            <option value="88">اثيوبيا</option>
                            <option value="89">اوغندة</option>
                            <option value="90">بوتسوانا</option>
                            <option value="91">بورندي</option>
                            <option value="92">تشاد</option>
                            <option value="93">تنزانيا</option>
                            <option value="94">توجو</option>
                            <option value="95">جابون</option>
                            <option value="96">غامبيا</option>
                            <option value="97">جزر القمر</option>
                            <option value="98">جنوب  افريقيا</option>
                            <option value="99">ناميبيا</option>
                            <option value="100">بنين</option>
                            <option value="101">رواندا</option>
                            <option value="102">زمبابوي</option>
                            <option value="103">زائير</option>
                            <option value="104">زامبيا</option>
                            <option value="105">ساحل العاج</option>
                            <option value="106">السنغال</option>
                            <option value="107">سيراليون</option>
                            <option value="108">غانا</option>
                            <option value="109">غينيا</option>
                            <option value="110">غينيابيساو</option>
                            <option value="111">بوركينافاسو</option>
                            <option value="112">الكاميرون</option>
                            <option value="113">الكونغو</option>
                            <option value="114">كينيا</option>
                            <option value="115">ليسوتو</option>
                            <option value="116">ليبيريا</option>
                            <option value="117">مالي</option>
                            <option value="118">ملاوي</option>
                            <option value="119">موريشيوس</option>
                            <option value="120">موزمبيق</option>
                            <option value="121">نيجيريا</option>
                            <option value="122">النيجر</option>
                            <option value="123">افريقيا الوسطى</option>
                            <option value="124">انجولا</option>
                            <option value="126">غينيا الإستوائية</option>
                            <option value="130">سويسرا</option>
                            <option value="134">فيندا</option>
                            <option value="135">ارتيريا</option>
                            <option value="136">دول افريقية اخري</option>
                            <option value="137">اسبانيا</option>
                            <option value="138">البانيا</option>
                            <option value="139">المانيا</option>
                            <option value="140">ايرلندا</option>
                            <option value="141">ايطاليا</option>
                            <option value="142">بريطانيا</option>
                            <option value="143">البرتغال</option>
                            <option value="144">بلغاريا</option>
                            <option value="145">بلجيكا</option>
                            <option value="146">بولندا</option>
                            <option value="147">تشيكوسلوفاكيا</option>
                            <option value="148">الدانمارك</option>
                            <option value="149">رومانيا</option>
                            <option value="150">السويد</option>
                            <option value="151">سويسرا</option>
                            <option value="152">فرنسا</option>
                            <option value="153">فنلندا</option>
                            <option value="154">هولندا</option>
                            <option value="155">يوغسلافيا</option>
                            <option value="156">اليونان</option>
                            <option value="157">اندورا</option>
                            <option value="158">النمسا</option>
                            <option value="159">هنغاريا</option>
                            <option value="160">ايسلندا</option>
                            <option value="162">لوكسمبورغ</option>
                            <option value="163">مالطا</option>
                            <option value="164">موناكو</option>
                            <option value="165">النرويج</option>
                            <option value="166">سان مورينو</option>
                            <option value="168">جبل طارق</option>
                            <option value="169">اوكرانيا</option>
                            <option value="170">روسيا البيضاء</option>
                            <option value="171">ارمينيا</option>
                            <option value="172">مولدافيا</option>
                            <option value="173">جورجيا</option>
                            <option value="174">ليتوانيا</option>
                            <option value="175">استونيا</option>
                            <option value="176">لاتفيا</option>
                            <option value="177">البوسنة والهرسك</option>
                            <option value="178">كرواتيا</option>
                            <option value="179">سلوفينيا</option>
                            <option value="180">صربيا</option>
                            <option value="181">مقدونيا</option>
                            <option value="182">كوسوفوا</option>
                            <option value="183">الجبل الأسود</option>
                            <option value="184">تشيك</option>
                            <option value="185">سلوفاكيا</option>
                            <option value="186">أمريكا</option>
                            <option value="187">الأرجنتين</option>
                            <option value="189">البرازيل</option>
                            <option value="190">بنما</option>
                            <option value="192">جامايكا</option>
                            <option value="193">جوانا</option>
                            <option value="194">فنزويلا</option>
                            <option value="195">كندا</option>
                            <option value="196">كولمبيا</option>
                            <option value="197">جزر البهاما</option>
                            <option value="198">كوستاريكا</option>
                            <option value="199">كوبا</option>
                            <option value="200">دومينيكا</option>
                            <option value="202">السلفادور</option>
                            <option value="203">جرانادا</option>
                            <option value="204">جواتيمالا</option>
                            <option value="205">هايتي</option>
                            <option value="206">هوندوراس</option>
                            <option value="207">المكسيك</option>
                            <option value="208">نيكاراجوا</option>
                            <option value="211">بوليفيا</option>
                            <option value="212">شيلي</option>
                            <option value="213">اكوادور</option>
                            <option value="214">باراجواي</option>
                            <option value="215">بيرو</option>
                            <option value="217">اوراجواي</option>
                            <option value="219">جرينلاند</option>
                            <option value="224">انجويلا</option>
                            <option value="242">استراليا</option>
                            <option value="243">نيوزيلندا</option>
                            <option value="245">جزر فيجي</option>
                            <option value="262">مدغشقر</option>
                            <option value="263">آخرى</option>

                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?=@$this->lang->line('register_birth_date');?></td>
                    <td><input type="text" placeholder="DD/MM/YYYY" name="birthDate" id="birthDate" maxlength="10" /></td>
                </tr>
                <tr>
                    <td><?=@$this->lang->line('register_mobile');?></td>
                    <td><input type="text" placeholder="05xxxxxxxx" name="mobile" id="mobile" maxlength="10" /></td>
                </tr>
                <tr>
                    <td><?=@$this->lang->line('register_password');?></td>
                    <td><input type="password" placeholder="Password" name="password" id="password" /></td>
                </tr>
                <tr>
                    <td><?=@$this->lang->line('register_repassword');?></td>
                    <td><input type="password" placeholder="Password" name="repassword" id="repassword" /></td>
                </tr>
                <tr>
                    <td><?=@$this->lang->line('register_email');?></td>
                    <td><input type="text" placeholder="your Email" name="email" id="email" /></td>
                </tr>
                <tr>
                    <td><?=@$this->lang->line('register_acadamic');?></td>
                    <td>
                        <select name="certificate" id="certificate" style="width:300px;">
                            <option value="1">ما دون الثانوية - Below Secondary School</option>
                            <option value="2">الثانوية العامة - Secondary School</option>
                            <option value="3">بكالوريس - Bsc</option>
                            <option value="4">ماجستير -  Master (Msc)</option>
                            <option value="5">دكتوراه -  Phd</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?=@$this->lang->line('register_specialization');?></td>
                    <td><input type="text" name="specialization" id="specialization" /></td>
                </tr>
                <tr>
                    <td><?=@$this->lang->line('register_gender');?></td>
                    <td>
                        <input type="radio" name="gender" id="gender" value="<?=@$this->lang->line('register_gender_male');?>" /><?=@$this->lang->line('register_gender_male');?>&nbsp;&nbsp;
                        <input type="radio" name="gender" id="gender" value="<?=@$this->lang->line('register_gender_female');?>" /><?=@$this->lang->line('register_gender_female');?>
                    </td>
                </tr>
                <tr>
                    <td><?=@$this->lang->line('register_address');?></td>
                    <td>
                        <textarea name="address" id="address"></textarea>
                    </td>
                </tr>
                <tr>
                    <td><?=@$this->lang->line('register_city');?></td>
                    <td>
                        <select name="city" id="city" style="width:300px;">
                            <option disabled="true">اختيار المدينه</option>
                            <option selected="selected" value="1">مكة المكرمة</option>
                            <option value="2">محافظة جدة</option>
                            <option value="3">محافظة الطائف</option>
                            <option value="4">محافظة القويعية</option>
                            <option value="5">محافظة وادي الدواسر</option>
                            <option value="6">محافظة المجمعة</option>
                            <option value="7">محافظة الخرج</option>
                            <option value="8">محافظة الأفلاج</option>
                            <option value="9">محافظة شقراء</option>
                            <option value="10">محافظة حوطة بني تميم</option>
                            <option value="11">محافظة الزلفي</option>
                            <option value="12">محافظة رماح</option>
                            <option value="13">محافظة عفيف</option>
                            <option value="14">محافظة حريملاء</option>
                            <option value="15">محافظة ثادق</option>
                            <option value="16">محافظة المزاحمية</option>
                            <option value="17">محافظة السليل</option>
                            <option value="18">محافظة ضرماء</option>
                            <option value="19">محافظة الغاط</option>
                            <option value="20">محافظة الحريق</option>
                            <option value="21">الرياض</option>
                            <option value="22">محافظة الدرعية</option>
                            <option value="23">محافظة الدوادمي</option>
                            <option value="24">محافظة القنفذة</option>
                            <option value="25">محافظة الليث</option>
                            <option value="26">محافظة رابغ</option>
                            <option value="27">محافظة الجموم</option>
                            <option value="28">محافظة خليص</option>
                            <option value="29">محافظة رنية</option>
                            <option value="30">محافظة تربه</option>
                            <option value="31">محافظة الكامل</option>
                            <option value="32">محافظة الخرمه</option>
                            <option value="33">المدينة المنورة</option>
                            <option value="34">محافظة ينبع</option>
                            <option value="35">محافظة العلا</option>
                            <option value="36">محافظة المهد</option>
                            <option value="37">محافظة الحناكية</option>
                            <option value="38">محافظة خيبر</option>
                            <option value="39">محافظة بدر</option>
                            <option value="40">بريدة</option>
                            <option value="41">محافظة عنيزة</option>
                            <option value="42">محافظة الرس</option>
                            <option value="43">محافظة البكيرية</option>
                            <option value="44">محافظة المذنب</option>
                            <option value="45">محافظة البدائع</option>
                            <option value="46">محافظة النبهانية</option>
                            <option value="47">محافظة رياض الخبراء</option>
                            <option value="48">محافظة الأسياح</option>
                            <option value="49">محافظة عيون الجواء</option>
                            <option value="50">محافظة الشماسية</option>
                            <option value="51">الدمام</option>
                            <option value="52">محافظة الأحساء</option>
                            <option value="53">محافظة القطيف</option>
                            <option value="54">محافظة حفر الباطن</option>
                            <option value="55">محافظة الخبر</option>
                            <option value="56">محافظة النعيرية</option>
                            <option value="57">محافظة قرية العليا</option>
                            <option value="58">محافظة بقيق</option>
                            <option value="59">محافظة الخفجي</option>
                            <option value="60">محافظة الجبيل</option>
                            <option value="61">ابها</option>
                            <option value="62">محافظة خميس  مشيط</option>
                            <option value="63">محافظة بيشة</option>
                            <option value="64">محافظة محايل</option>
                            <option value="65">محافظة النماص</option>
                            <option value="66">محافظة أحد رفيدة</option>
                            <option value="67">محافظة ظهران الجنوب</option>
                            <option value="68">محافظة بالقرن</option>
                            <option value="69">محافظة سراة عبيدة</option>
                            <option value="70">محافظة المجاردة</option>
                            <option value="71">محافظة رجال ألمع</option>
                            <option value="72">محافظة تثليث</option>
                            <option value="74">حائل</option>
                            <option value="75">محافظة بقعاء</option>
                            <option value="76">محافظة الغزالة</option>
                            <option value="77">محافظة الشنان</option>
                            <option value="78">تبوك</option>
                            <option value="79">محافظة ضباء</option>
                            <option value="80">محافظة تيماء</option>
                            <option value="81">محافظة الوجه</option>
                            <option value="82">محافظة حقل</option>
                            <option value="83">محافظة أملج</option>
                            <option value="84">الباحة</option>
                            <option value="85">محافظة بالجرشي</option>
                            <option value="86">محافظة المخواة</option>
                            <option value="87">محافظة المندق</option>
                            <option value="88">محافظة العقيق</option>
                            <option value="89">محافظة قلوة</option>
                            <option value="91">محافظة القرى</option>
                            <option value="92">عرعر</option>
                            <option value="93">محافظة رفحاء</option>
                            <option value="94">محافظة طريف</option>
                            <option value="95">الجوف</option>
                            <option value="96">محافظة القريات</option>
                            <option value="97">محافظة دومة الجندل</option>
                            <option value="98">جازان</option>
                            <option value="99">محافظة صبياء</option>
                            <option value="100">محافظة صامطة</option>
                            <option value="101">محافظة الدائر</option>
                            <option value="102">محافظة القياس</option>
                            <option value="103">محافظة العيدابي</option>
                            <option value="104">محافظة بيش</option>
                            <option value="105">محافظة العارضة</option>
                            <option value="106">محافظة الحرث</option>
                            <option value="107">محافظة الريث</option>
                            <option value="108">محافظة ضمد</option>
                            <option value="109">نجران</option>
                            <option value="110">محافظة شرورة</option>
                            <option value="111">محافظة بدر الجنوب</option>
                            <option value="112">محافظة حبونا</option>
                            <option value="113">محافظة ثار</option>
                            <option value="114">محافظة يدمة</option>
                            <option value="124">ينبع الصناعية</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="<?=$this->lang->line('register_step2');?>" /></td>
                </tr>
                <?php if($ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('login_error');?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
<?php elseif($STEP == 3): ?>
    <form method="post"  enctype="multipart/form-data">
        <input type="hidden" name="step" value="3" />
        <input type="hidden" name="ID" value="<?=@$ID?>" />
        <table class="tbl" style="width: 50%;margin-top: 15px;">
            <thead>
                <tr>
                    <td colspan="2"><?=$this->lang->line('register_upload_files');?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$this->lang->line('register_upload_picture');?></td>
                    <td><input type="file" name="picture" id="picture" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('register_upload_identity');?></td>
                    <td><input type="file" name="identity" id="identity" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('register_upload_certificate');?></td>
                    <td><input type="file" name="certificate" id="certificate" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('register_upload_training');?></td>
                    <td><input type="file" name="training" id="training" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="<?=$this->lang->line('register_step3');?>" /> &nbsp;&nbsp;<input type="submit" name="skip" value="<?=$this->lang->line('register_skip');?>" /></td>
                </tr>
                <?php if($ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('register_uploaded_error');?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
<?php elseif($STEP == 4): ?>
<div class="message">
    <?=@$MSG?>
</div>
<?php endif; ?>

