<template>
    <div class="modal fade" id="show" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="adminModalLabel">
                        {{ $t('global.show') }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #e6e6e6" v-if="surah">
                    <div class="row">

                        <!-- <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">{{ $t('global.surah_name') }}: {{ surah.name }}</h5>
                                <span class="badge bg-primary">{{ $t('global.verse_count') }}: {{ surah.verse_count
                                    }}</span>
                            </div>
                            <div v-if="loading" class="text-center">
                                <loader />
                            </div>
                            <div v-else>
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="(ayah, index) in ayahs" :key="index">
                                        <span class="text-muted">{{ $t('global.verse') }} {{ index + 1 }}:</span>
                                        <span class="text-dark">{{ ayah.text }}</span>
                                        <span class="text-secondary" style="font-size: 0.9em;">({{ ayah.translation
                                            }})</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                {{ $t('global.close') }}
                            </button>
                        </div> -->

                        <div class="col-md-12">
                            <div id="quran-tab" class="quran quran-tab trans-tab" data="simple.305"
                                style="font-size: 19px;">
                                <div class="quranPageHeader ui-helper-clearfix">
                                    <div style="float: left; width: 35%; text-align: left"><span class="suraName">{{surah.name}}</span>
                                    </div>
                                    <div style="float: left; width: 30%;">
                                        <a class="arrow-link arrow-left" href="javascript:changePage('left')"
                                            original-title="">◄</a>
                                        &nbsp;<span class="pageNumber">{{makeNumberArabic(ayahs[0]?.page)}}</span>&nbsp;
                                        <a class="arrow-link arrow-right" href="javascript:changePage('right')"
                                            original-title="">►</a>
                                    </div>
                                    <div style="float: right"><span class="juzName">{{toOrdinalFraction(ayahs[0]?.juz)}}</span> </div>
                                </div>
                                <div class="qFrame qFrameTop">
                                </div>
                                <div class="qFrame qFrameMiddle " id="middleFrame">
                                    <div class="quranText" id="quranText"
                                        style="font-family: hafs; font-size: 1.15em; text-align: justify; direction: rtl;">
                                        <div class="suraHeaderFrame rtl">{{surah.name}}</div>
                                        <div class="ayaText bism">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ </div>
                                        <span v-for="(ayah, index) in ayahs" :key="index" id="19-1" class="aya selected">{{ ayah.text }} <span class="ayaNumber"
                                                style="font-size: 0.91em;">‎﴿{{makeNumberArabic(ayah.number_in_surah)}}﴾‏</span></span>

                                    </div>
                                    <div class="transText" id="transText" style="display: none;">
                                    </div>
                                </div>
                                <div class="qFrame qFrameBottom">
                                </div>
                                <div class="quranPageFooter">
                                    <a class="arrow-link arrow-left" href="javascript:changePage('left')"
                                        original-title="">◄</a>
                                    &nbsp;<span class="pageNumber">{{makeNumberArabic(ayahs[0]?.page)}}</span>&nbsp;
                                    <a class="arrow-link arrow-right" href="javascript:changePage('right')"
                                        original-title="">►</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import { useI18n } from "vue-i18n";
import adminApi from "../../../api/adminAxios";
export default {
    name: "Show",
    props: {
        dataRow: { default: '' },
    },
    components: {
    },
    data() {
        return {
            errors: {}
        }
    },
    setup(props) {
        setTimeout(async () => {
            let myModalEl = document.getElementById('show')
            myModalEl.addEventListener('show.bs.modal', function (event) {
                resetModal();
            })
            myModalEl.addEventListener('hidden.bs.modal', function (event) {
                defaultData();
            })
        }, 150);
        let loading = ref(false);
        const { t } = useI18n({});
        const id = ref(null);
        const surah = ref('');
        const ayahs = ref([]);

        function defaultData() {
            surah.value = '';
            id.value = null;
            ayahs.value = [];
        }

        function resetModal() {
            defaultData();
            setTimeout(async () => {
                id.value = props.dataRow.id;
                surah.value = props.dataRow;
                await showSurah(props.dataRow.page);
            }, 50);
        }

        let makeNumberArabic = (num) => {
            return num.toString().replace(/\d/g, d => '٠١٢٣٤٥٦٧٨٩'[d]);
        }

        function toOrdinalFraction(number) {
            const ordinals = [
                "الأول", "الثاني", "الثالث", "الرابع", "الخامس", "السادس", "السابع", "الثامن", "التاسع", "العاشر",
                "الحادي عشر", "الثاني عشر", "الثالث عشر", "الرابع عشر", "الخامس عشر", "السادس عشر", "السابع عشر", "الثامن عشر", "التاسع عشر", "العشرون",
                "الحادي والعشرون", "الثاني والعشرون", "الثالث والعشرون", "الرابع والعشرون", "الخامس والعشرون", "السادس والعشرون", "السابع والعشرون", "الثامن والعشرون", "التاسع والعشرون", "الثلاثون"
            ];

            return number >= 1 && number <= 30 ? `الجزء ${ordinals[number - 1]}` : `الجزء رقم ${number}`;
        }


        let showSurah = (page) => {
            loading.value = true;
            adminApi.get(`dashboard/quran/${id.value}?page=${page}`)
                .then((res) => {
                    let l = res.data.data;
                    if (l && l.length > 0) {
                        ayahs.value = l;
                    }
                })
                .catch((err) => {
                    console.log(err);
                })
                .finally(() => {
                    loading.value = false;
                });
        }

        return { t, id, loading, surah, ayahs,makeNumberArabic,toOrdinalFraction }
    }
}
</script>

<style scoped>
#quran-tab {
    font-size: 19px;
}

.quran {
    width: 500px;
    margin: 4px 32px;
    padding-top: 20px;
    direction: ltr;
}

.quranPageHeader,
.quranPageFooter {
    direction: ltr;
    text-align: center;
    font-family: "Times New Roman";
    font-weight: bold;
    font-size: 16px;
    padding: 5px;
    color: #333;
}

.ui-helper-clearfix {
    display: block;
}

.arrow-link {
    font-family: "Times New Roman";
    color: #aaa;
    font-size: 0.9em;
    text-decoration: none;
}

.ui-helper-clearfix:after {
    content: ".";
    display: block;
    height: 0;
    clear: both;
    visibility: hidden;
}

.qFrameTop {
    height: 23px;
}

.qFrame {
    background: #f7fce3 url(../../../assets/images/frame.png) repeat-y;
}

.qFrameMiddle {
    background-position: -500px 0;
    line-height: 2.35em;
    font-family: "Traditional Arabic", Scheherazade, "Times New Roman";
}

.quranText {
    direction: rtl;
    font-size: 1.15em;
    text-align: justify;
    margin: 0px 30px;
    padding: 16px 14px;
    color: black;
}

.suraHeaderFrame {
    background: url(../../../assets/images/sura-frame.png) no-repeat center center;
    margin: 5px 0px;
    text-align: center;
    font-family: hafs, "Times New Roman";
    font-size: 20px;
    line-height: 45px;
    height: 49px;
}

.bism {
    text-align: center;
}

.aya {
    transition: background 0.6s;
    -webkit-tap-highlight-color: transparent;
}

.quranText .ayaNumber {
    font-family: hafs;
}

.ayaNumber {
    font-size: 0.9em;
    white-space: nowrap;
    color: #050;
    cursor: pointer;
}



.qFrameBottom {
    background-position: 0 bottom;
    height: 23px;
}
</style>
