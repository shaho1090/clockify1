<div style="float: right; margin:25px;  border: 1px solid #999999;">
    <div class="btn-group-vertical">
        <form><button type="submit" formaction="{{ route('work-time.index') }}" formmethod="get" class="btn btn-outline-secondary">زمان های کاری</button></form>
        <form><button type="submit" formaction="{{ route('projects.index') }}" formmethod="get" class="btn btn-outline-secondary">لیست پروژه ها</button></form>
        <form><button type="submit" formaction="{{ route('tags.index') }}" formmethod="get" class="btn btn-outline-secondary">لیست تگ ها</button></form>
        <form><button type="submit" formaction="{{ route('members.index') }}" formmethod="get" class="btn btn-outline-secondary">تیم </button></form>
    </div>
</div>

