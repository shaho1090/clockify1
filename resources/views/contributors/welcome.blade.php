<div> خوش آمدید</div>
       <div>
            با سلام شما به پروژه {!!$project_title ?? ''!!} دعوت شده اید. <br />اگر عضو نیستید از طریق <a href="http://localhost/clockify1/public/register"> این لینک  </a>ثبت نام کنید و یا وارد <a href="http://localhost/clockify1/public/contributors/invited/{!! $project_id !!}"> حساب کاربری  </a>خود شوید.
       </div>
       <input type="hidden" name="project_id" value="{!! $project_id !!}">
       <label>{!! $project_id !!}</label>
</div>



