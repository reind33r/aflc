<template>
    <div>
        <div v-if="error_message" class="alert alert-danger" v-html="error_message">
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center"><i class="fas fa-sort"></i></th>
                    <th>Nom</th>
                    <th>Lien vers</th>
                    <th>Visible pour</th>
                    <th class="text-center"><i class="far fa-trash-alt"></i></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in sorted_items" v-bind:key="item.id"
                    @dragover.prevent="dragOver(item.id)"
                    @dragleave="draggedOver = false"
                    @dragstart="dragStart(item.id, $event)"
                    @dragend="dragEnd"
                    @drop.prevent="handleDrop(item_order[item.id], $event)"
                    v-bind:class="{draggedOver: draggedOver == item.id}"
                >
                    <td class="text-center align-middle">
                        <i class="fas fa-lg fa-grip-lines px-1 py-2" draggable></i>
    
                        <br>{{ item_order[item.id] }}
                    </td>
                    <td class="align-middle">
                        <input type="text" v-model="item.name">
                    </td>
                    <td class="align-middle">
                        <div class="row">
                            <div class="col-lg">
                                <select class="custom-select" v-model="item_link_type[item.id]" @change="updateItemVisibility(item)">
                                    <option value="">--- Sélectionner une option ---</option>
                                    <option value="cms">Page du site :</option>
                                    <option value="internal">Page spéciale :</option>
                                    <option value="external">Lien externe :</option>
                                </select>
                            </div>
        
                            <div class="col-lg">
                                <select v-if="item_link_type[item.id] == 'cms'" class="custom-select" v-model="item.cms_page_uri" @change="updateItemVisibility(item)">
                                    <option value="">--- Sélectionner une page ---</option>
                                    <option
                                        v-for="page in cmsPages"
                                        v-bind:key="page.uri"
                                        v-bind:value="page.uri"
                                    >
                                        {{ page.title }} [/{{ page.uri }}]
                                    </option>
                                </select>
            
                                <select v-if="item_link_type[item.id] == 'internal'" class="custom-select" v-model="item.internal_link" @change="updateItemVisibility(item)">
                                    <option value="">--- Sélectionner une page ---</option>
                                    <option
                                        v-for="page in internalPages"
                                        v-bind:key="page.id"
                                        v-bind:value="page.id"
                                    >
                                        {{ page.name }}
                                    </option>
                                </select>
            
                                <input type="url" class="form-control" v-if="item_link_type[item.id] == 'external'" v-model="item.external_link" placeholder="https://" required>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle">
                        <select class="custom-select" v-model="item.visibility" :disabled="item_link_type[item.id] != 'external'">
                            <option value="all">Tous</option>
                            <option value="race_registered">Inscrits à la course</option>
                            <option value="race_not_registered">Non inscrits à la course</option>
                            <option value="race_organizer">Organisateurs de la course</option>
                        </select>
                    </td>
                    <td class="text-center align-middle">
                        <button class="btn btn-sm btn-link text-danger" @click="removeItem(item.id, item.is_new)"><i class="far fa-trash-alt"></i></button>
                    </td>
                </tr>

                <tr>
                    <td colspan="5" class="text-center align-middle">
                        <button class="btn btn-success" @click="addItem">Ajouter</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button class="btn btn-primary" @click="saveChanges">Sauvegarder les changements</button>
    </div>
</template>

<script>
    export default {
        props: ['initialItems', 'cmsPages', 'internalPages', 'save_changes_uri'],

        data: function() {
            return {
                items: null,
                item_link_type: [],
                item_order: [],
                draggedOver: false,
                isDragging: false,
                recompute_sort: false,
                error_message: false,
                removed_items_ids: [],
            }
        },

        computed: {
            sorted_items: function() {
                this.recompute_sort;

                let self = this;
                return self.items.sort(function(a,b) {
                    return self.item_order[a.id] - self.item_order[b.id];
                });
            }
        },

        created: function() {
            let self = this;

            self.items = self.initialItems;

            var i = 0;
            self.items.forEach(function(item) {
                self.item_order[item.id] = i;
                i++;

                item.is_new = false;

                if(item.cms_page_uri !== null) {
                    self.item_link_type[item.id] = 'cms';
                } else if(item.internal_link !== null) {
                    self.item_link_type[item.id] = 'internal';
                } else {
                    self.item_link_type[item.id] = 'external';
                }
            });
        },

        methods: {
            dragStart(which, ev) {
                ev.dataTransfer.setData("text", which);
                this.isDragging = true;
            },
            dragOver(which) {
                this.draggedOver = which;
            },
            dragEnd(ev) {
                this.isDragging = false;
            },
            handleDrop(which, ev) {
                this.draggedOver = false;
                let self = this;

                var from_id = ev.dataTransfer.getData("text");
                
                var from_order = self.item_order[from_id];
                var to_order = which;
                
                if(from_order == to_order) {
                    return;
                }
                
                self.sorted_items.forEach(function(item) {
                    if(to_order > from_order && self.item_order[item.id] >= from_order && self.item_order[item.id] <= to_order) {
                        self.item_order[item.id] -= 1;
                    }

                    else if(to_order < from_order && self.item_order[item.id] >= to_order && self.item_order[item.id] <= from_order) {
                        self.item_order[item.id] += 1;
                    }
                });

                self.item_order[from_id] = to_order;

                self.recompute_sort = !self.recompute_sort;
            },
            updateItemVisibility(item) {
                if(this.item_link_type[item.id] == 'cms') {
                    var page = this.cmsPages.find(function(c_page) {
                        return c_page.uri == item.cms_page_uri;
                    });

                    item.visibility = page.visibility;
                } else if(this.item_link_type[item.id] == 'internal') {
                    var page = this.internalPages.find(function(c_page) {
                        return c_page.id == item.internal_link;
                    });

                    item.visibility = page.visibility;
                }
            },
            addItem() {
                var new_length = this.items.push({
                    cms_page_uri: '',
                    external_link: '',
                    internal_link: '',
                    is_new: true,
                    visibility: 'all',
                });

                var new_id = this.item_order.push(new_length - 1) - 1;
                this.items[new_length - 1].id = new_id;
                this.item_link_type[new_id] = '';
                this.recompute_sort = !this.recompute_sort;
            },
            removeItem(id, is_new) {
                this.items = this.items.filter(item => item.id !== id);
                
                if(!is_new) {
                    this.removed_items_ids.push(id);
                }

                this.recompute_sort = !this.recompute_sort;
            },
            saveChanges() {
                var formData = new FormData();

                let self = this;

                this.items.forEach(function(item) {
                    var prepend_i = 'item[' + self.item_order[item.id] + ']';
                    formData.append(prepend_i + '[name]', item.name);
                    formData.append(prepend_i + '[order]', self.item_order[item.id]);

                    if(!item.is_new) {
                        formData.append(prepend_i + '[id]', item.id);
                    }

                    if(self.item_link_type[item.id] == 'cms') {
                        formData.append(prepend_i + '[cms_page_uri]', item.cms_page_uri);
                    } else if(self.item_link_type[item.id] == 'internal') {
                        formData.append(prepend_i + '[internal_link]', item.internal_link);
                    } else {
                        formData.append(prepend_i + '[external_link]', item.external_link);
                        formData.append(prepend_i + '[visibility]', item.visibility);
                    }
                });

                this.removed_items_ids.forEach(function(id_to_remove) {
                    formData.append('remove_item_ids[]', id_to_remove);
                });

                axios.post(self.save_changes_uri, formData)
                    .then(res => {
                        if(res.status == 200 && res.data.redirect_to) {
                            window.location.href = res.data.redirect_to;
                        } else {
                            self.error_message = "<p class=\"mb-0\">Une erreur inconnue s'est produite (code VJS-EM-100).</p>";
                        }
                    }).catch(err => {
                        if (err.response && err.response.status == 422) {
                            self.error_message = "<p>L'enregistrement n'a pas été effectué car :</p>";
                            self.error_message += "<ul class=\"mb-0\">";

                            for(var err_key in err.response.data.errors) {
                                err.response.data.errors[err_key].forEach(function(error) {
                                    self.error_message += "<li>" + error + "</li>";
                                });
                            }

                            self.error_message += "</ul>";
                        }
                    });
            }
        }
    }
</script>
