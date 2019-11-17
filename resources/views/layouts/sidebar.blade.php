<div style="float: right; margin-top:25px; margin-bottom: 10px;margin-left: 10px; margin-right: 15px; ">
    <div class="form-group" >
        <form><button type="submit" formaction="{{ route('work-time.index') }}" formmethod="get" class="btn btn-outline-secondary btn-block btn-lg">زمان های کاری</button></form>
        <form><button type="submit" formaction="{{ route('projects.index') }}" formmethod="get" class="btn btn-outline-secondary btn-block  btn-lg">لیست پروژه ها</button></form>
        <form><button type="submit" formaction="{{ route('tags.index') }}" formmethod="get" class="btn btn-outline-secondary btn-block  btn-lg">لیست تگ ها</button></form>
        <form><button type="submit" formaction="{{ route('members.index') }}" formmethod="get" class="btn btn-outline-secondary btn-block  btn-lg">تیم </button></form>
    </div>
</div>

