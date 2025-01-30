@component("components.layout.appshell", [
    "title" => t("Animations"),
    "breadcrumbs" => $breadcrumbs ?? []
])
    <h1 class="mb-2">
        @if(!empty($animation))
            {{ t("Edit animation \$\$name\$\$", ["name" => $animation->getName()]) }}
        @else
            {{ t("Create animation") }}
        @endif
    </h1>

    <form method="post" action="{{ Router::generate("animation-save") }}">
        @if(!empty($animation))
            <input type="hidden" name="animation" value="{{ $animation->getId() }}">
        @endif

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label for="name" class="{{ TailwindUtil::$inputLabel }}" data-required>
                {{ t("Animation name") }}
            </label>
            <input id="name"
                   name="name"
                   type="text"
                   class="{{ TailwindUtil::$input }}"
                   value="{{ !empty($animation) ? $animation->getName() : "" }}"
                   placeholder="{{ t("Animation name") }}"
                   maxlength="256"
                   required>
        </div>

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label for="type" class="{{ TailwindUtil::$inputLabel }}" data-required>
                {{ t("Animation type") }}
            </label>
            <select id="type"
                    name="type"
                    class="{{ TailwindUtil::$select }}"
                    required>
                @foreach(AnimationType::cases() as $animationType)
                    <option value="{{ $animationType->value }}"
                            @if(!empty($animation) && $animation->getAnimationType() === $animationType->value) selected @endif>
                        {{ $animationType->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label for="durationPerColor" class="{{ TailwindUtil::$inputLabel }}" data-required>
                {{ t("Duration per color") }}
            </label>
            <input id="durationPerColor"
                   name="durationPerColor"
                   type="number"
                   min="1"
                   step="1"
                   class="{{ TailwindUtil::$input }}"
                   value="{{ !empty($animation) ? $animation->getDurationPerColor() : "" }}"
                   placeholder="{{ t("Duration per color") }}"
                   required>
        </div>

        <div class="">
            <span class="{{ TailwindUtil::$inputLabel }}">
                {{ t("Colors") }} <span class="text-primary">*</span>
            </span>

            <div id="color-inputs">
                @if(isset($animation))
                    @foreach($animation->getParsedColors() as $color)
                        <div class="color-input-group {{ TailwindUtil::inputGroup(true) }} mb-2">
                            <input name="colors[]"
                                   type="color"
                                   class="w-full bg-background border border-gray outline-primary rounded placeholder:text-font-light"
                                   value="{{ $color }}"
                                   placeholder="{{ t("Color") }}"
                                   required>
                            <button type="button" class="remove-color-button {{ TailwindUtil::button(true) }} gap-2">
                                @include("components.icons.delete")
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="color-input-group {{ TailwindUtil::inputGroup(true) }} mb-2">
                        <input name="colors[]"
                               type="color"
                               class="w-full bg-background border border-gray outline-primary rounded placeholder:text-font-light"
                               placeholder="{{ t("Color") }}"
                               required>
                        <button type="button" class="remove-color-button {{ TailwindUtil::button(true) }} gap-2">
                            @include("components.icons.delete")
                        </button>
                    </div>
                @endif
            </div>

            <button id="add-color-button" type="button" class="{{ TailwindUtil::button() }} mb-2" data-template="color-input-template">
                @include("components.icons.plus")
                {{ t("Add color") }}
            </button>

            <div id="color-input-template" class="hidden color-input-group {{ TailwindUtil::inputGroup(true) }} mb-2">
                <input name="color"
                       type="color"
                       class="w-full bg-background border border-gray outline-primary rounded placeholder:text-font-light"
                       placeholder="{{ t("Color") }}"
                       required>
                <button type="button" class="remove-color-button {{ TailwindUtil::button(true) }} gap-2">
                    @include("components.icons.delete")
                </button>
            </div>
        </div>

        <button type="submit" class="{{ TailwindUtil::button() }} gap-2">
            @include("components.icons.buttonload")
            @include("components.icons.save")
            {{ t("Save") }}
        </button>

        @if(!empty($animation))
            <button type="button"
                    id="delete-animation"
                    class="{{ TailwindUtil::button(false, "danger") }} gap-2"
                    data-delete-href="{{ Router::generate("animation-delete", ["animation" => $animation->getId()]) }}">
                @include("components.icons.buttonload")
                @include("components.icons.delete")
                {{ t("Delete") }}
            </button>
        @endif
    </form>

    @include("components.modals.defaultabort")
    <script type="module">
        import * as AnimationsEdit from "{{ Router::staticFilePath("js/animations/edit.js") }}";
        AnimationsEdit.init();
    </script>
@endcomponent
