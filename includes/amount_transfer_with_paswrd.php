<?php
error_reporting(0);

echo "<table>";
echo " <tr>
                 <td style='text-align: center;' colspan='2'>
                 <input type='radio' name='charger' /> চার্জ প্রেরকের &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 <input type='radio' name='charger' /> চার্জ প্রাপকের
                 </td>
                 </tr>
                 <tr>
                    <td style='text-align: right; width: 40%;'>ট্রান্সফার এমাউন্ট</td>
                    <td style='width: 60%;' >: <input  class='box' type='text' /> টাকা</td>   
                 </tr>
                 <tr>
                    <td style='text-align: right; width: 30%;'>ট্রান্সফার চার্জ</td>
                    <td>: <input  class='box' type='text' /> টাকা</td>   
                 </tr>
                 <tr>
                    <td style='text-align: right; width: 30%;'>টোটাল এমাউন্ট</td>
                    <td>: <input  class='box' type='text' /> টাকা</td>   
                 </tr>
                  <tr>
                    <td style='text-align: right; width: 30%;'>পাসওয়ার্ড লিখুন</td>
                    <td>: <input  class='box' type='password' name='password1'  id='password1' onblur='checkCorrectPass();'/><span id='showError'></span></td>   
                 </tr>
                    <tr>
                        <td style='text-align: right; width: 30%;'>পুনরায় পাসওয়ার্ড লিখুন</td>
                        <td>:  <input  class='box' type='password' name='password2'  id='password2' onkeyup='checkPass(this.value); '/> 
                            <span id='passcheck'></span></td>   
                    </tr>
                    <tr>                    
                        <td colspan='2' style='text-align:center; ' ></br><input class='btn' style =' font-size: 12px; ' onclick='beforeSave();' type='submit' id='save' name='save' disabled value='ট্রান্সফার করুন' /></td>                           
                    </tr></table>";
?>