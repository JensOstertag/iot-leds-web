@component("components.layout.appshell", [
    "title" => t("System settings"),
    "breadcrumbs" => $breadcrumbs ?? []
])
    <h1 class="mb-2">
        {{ t("System settings") }}
    </h1>

    <form method="post" action="{{ Router->generate("system-settings-save") }}">
        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <input id="registrationEnabled"
                   name="registrationEnabled"
                   type="checkbox"
                   class="{{ TailwindUtil::$checkbox }}"
                   value="1"
                   @if($registrationEnabled === "true") checked @endif>
            <label for="registrationEnabled" class="{{ TailwindUtil::$inputLabel }}" data-required>
                {{ t("Registration enabled") }}
            </label>
        </div>

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label for="webSocketHost" class="{{ TailwindUtil::$inputLabel }}" data-required>
                {{ t("WebSocket server host") }}
            </label>
            <input id="webSocketHost"
                   name="webSocketHost"
                   type="text"
                   class="{{ TailwindUtil::$input }}"
                   value="{{ $webSocketHost }}"
                   placeholder="{{ t("WebSocket server host") }}"
                   required>
        </div>

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label for="webSocketChannel" class="{{ TailwindUtil::$inputLabel }}" data-required>
                {{ t("WebSocket server channel") }}
            </label>
            <input id="webSocketChannel"
                   name="webSocketChannel"
                   type="text"
                   class="{{ TailwindUtil::$input }}"
                   value="{{ $webSocketChannel }}"
                   placeholder="{{ t("WebSocket server channel") }}"
                   required>
        </div>

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label for="webSocketToken" class="{{ TailwindUtil::$inputLabel }}">
                {{ t("WebSocket server token") }}
            </label>
            <input id="webSocketToken"
                   name="webSocketToken"
                   type="text"
                   class="{{ TailwindUtil::$input }}"
                   value="{{ $webSocketToken }}"
                   placeholder="{{ t("WebSocket server token") }}"
                   readonly>
        </div>

        <button type="submit" class="{{ TailwindUtil::button() }} gap-2">
            @include("components.icons.buttonload")
            @include("components.icons.save")
            {{ t("Save") }}
        </button>
    </form>
@endcomponent
