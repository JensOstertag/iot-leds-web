@component("components.layout.appshell", [
    "title" => t("User management"),
    "breadcrumbs" => $breadcrumbs ?? []
])
    <h1 class="mb-2">
        @if(!empty($account))
            {{ t("Edit user \$\$name\$\$", ["name" => $account->getUsername()]) }}
        @else
            {{ t("Create user") }}
        @endif
    </h1>

    <form method="post" action="{{ Router::generate("user-save") }}">
        @if(!empty($account))
            <input type="hidden" name="user" value="{{ $account->getId() }}">
        @endif

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label for="email" class="{{ TailwindUtil::$inputLabel }}" data-required>
                {{ t("Email") }}
            </label>
            <input id="email"
                   name="email"
                   type="email"
                   class="{{ TailwindUtil::$input }}"
                   value="{{ !empty($account) ? $account->getEmail() : "" }}"
                   placeholder="{{ t("Email") }}"
                   maxlength="256"
                   required>
        </div>

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label for="username" class="{{ TailwindUtil::$inputLabel }}" data-required>
                {{ t("Username") }}
            </label>
            <input id="username"
                   name="username"
                   type="text"
                   class="{{ TailwindUtil::$input }}"
                   value="{{ !empty($account) ? $account->getUsername() : "" }}"
                   placeholder="{{ t("Username") }}"
                   maxlength="256"
                   required
                   pattern="(?!.*\.\.)(?!.*\.$)[^\W][\w.]{2,15}">
        </div>

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label class="{{ TailwindUtil::$inputLabel }}"
                   for="password"
                   @if(empty($account)) data-required @endif>
                {{ t("Password") }}
                @if(!empty($account)) ({{ t("leave empty to keep old one") }}) @endif
            </label>
            <input class="{{ TailwindUtil::$input }}"
                   type="password"
                   name="password"
                   id="password"
                   placeholder="{{ t("Password") }}"
                   @if(empty($account)) data-required @endif
                   pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[\d\W]).{8,}">
        </div>

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <input class="{{ TailwindUtil::$checkbox }}"
                   type="checkbox"
                   name="admin"
                   id="admin"
                   value="1"
                   @if(!empty($account) && $account->getPermissionLevel() === PermissionLevel::ADMIN->value) checked @endif>
            <label class="{{ TailwindUtil::$inputLabel }}"
                     for="admin">
                 {{ t("Administrator") }}
            </label>
        </div>

        <button type="submit" class="{{ TailwindUtil::button() }} gap-2">
            @include("components.icons.buttonload")
            @include("components.icons.save")
            {{ t("Save") }}
        </button>

        @if(!empty($account))
            <button type="button"
                    id="delete-user"
                    class="{{ TailwindUtil::button(false, "danger") }} gap-2"
                    data-delete-href="{{ Router::generate("user-delete", ["user" => $account->getId()]) }}">
                @include("components.icons.buttonload")
                @include("components.icons.delete")
                {{ t("Delete") }}
            </button>
        @endif
    </form>

    @include("components.modals.defaultabort")
    <script type="module">
        import * as UsersEdit from "{{ Router::staticFilePath("js/users/edit.js") }}";
        UsersEdit.init();
    </script>
@endcomponent
