<a class="text-pos text-button" href="#modal" rel="modal:open">@icon('user'){{ trans('Use for auth') }}</a>

<div id="modal" class="modal">
    <multiselect v-model="selected"
                 label="name"
                 track-by="name"
                 placeholder="Type to search"
                 open-direction="bottom"
                 :options="users"
                 :searchable="true"
                 :loading="isLoading"
                 :internal-search="false"
                 :clear-on-select="false"
                 :close-on-select="true"
                 :options-limit="300"
                 :limit="3"
                 :limit-text="limitText"
                 :max-height="600"
                 :show-no-results="false"
                 @select="getLink"
                 :hide-selected="true" @search-change="asyncFind">
    </multiselect>


    <input v-if="selected" type="text" readonly v-model="link" style="width:100%; margin: 10px 0 10px 0;">
</div>