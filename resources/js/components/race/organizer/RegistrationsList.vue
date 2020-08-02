<template>
    <div>
        <form onsubmit="return false;">
            <input  type="text" name="file_number" id="search_file_number"
                    placeholder="Rechercher un numéro de dossier, un pilote, ..."
                    class="form-control text-center h4"
                    autofocus
                    v-model="searchNeedle"
            >
        </form>
    
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom de l'équipe</th>
                    <th>Pilotes</th>
                    <th>Caisses à savon</th>
                    <th>Paiements</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="team in computedTeams" v-bind:key="team.id">
                    <td>
                        <a target="_blank" :href="team_detail_uri.replace('__FILE_NUMBER__', team.file_number)">{{ team.file_number }}</a>
                    </td>
                    <td>
                        {{ team.name }}
                    </td>
                    <td>
                        <ul>
                            <li v-for="pilot in team.pilots" v-bind:key="pilot.id">
                                {{ pilot.fullName }}

                                <i class="fas fa-check-circle text-success" v-if="pilot.validated"></i>
                                <i class="fas fa-exclamation-triangle text-warning" v-if="!pilot.validated || !pilot.allDocumentsValid"></i>
                            </li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li v-for="soapbox in team.soapboxes" v-bind:key="soapbox.id">
                                {{ soapbox.name }}

                                <i class="fas fa-check-circle text-success" v-if="soapbox.validated"></i>
                                <i class="fas fa-exclamation-triangle text-warning" v-if="!soapbox.validated"></i>
                            </li>
                        </ul>
                    </td>
                    <td>
                        <i class="fas fa-check-circle text-success" v-if="team.payment_received == team.total_fee"></i>
                        <i class="fas fa-exclamation-triangle text-warning" v-if="team.payment_received < team.total_fee"></i>
                        <i class="fas fa-exclamation-circle text-danger" v-if="team.payment_received > team.total_fee"></i>


                        {{ team.payment_received | currency }} reçus
                        /
                        {{ team.total_fee | currency }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['teams', 'team_detail_uri'],

        data: function() {
            return {
                searchNeedle: '',
                _teams: [],
            }
        },


        created: function() {
            this._teams = this.teams;

            this._teams.forEach(function(team) {
                team.haystack = team.file_number;
                team.haystack += team.name;
                team.pilots.forEach(function(pilot) {
                    team.haystack += pilot.fullName;
                });
                team.soapboxes.forEach(function(soapbox) {
                    team.haystack += soapbox.name;
                });
            });
        },

        computed: {
            lowerCaseSearchNeedle: function() {
                return this.searchNeedle.toLowerCase();
            },
            computedTeams: function() {
                var teams = this._teams;
                var searchNeedle = this.lowerCaseSearchNeedle;

                if(!searchNeedle) {
                    return teams;
                }

                return teams.filter(function(team) {
                    return Object.keys(team).some(function(key) {
                        return (
                            team.haystack.toLowerCase().indexOf(searchNeedle) > -1
                        );
                    });
                });
            }
        },

        filters: {
            currency: function(amount_in_cents) {
                return (amount_in_cents / 100).toLocaleString('fr-FR', { style: "currency", currency: 'EUR' });
            }
        }
    }
</script>
