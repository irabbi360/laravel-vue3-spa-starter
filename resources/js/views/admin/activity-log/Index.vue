<template>
    <div class="container my-2">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Activity Logs</h4>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-download me-2"></i>Export
                                </button>
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-filter me-2"></i>Filter
                                </button>
                            </div>
                        </div>

                        <!-- Search and Filter -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="search-box bg-white">
                                    <i class="fas fa-search text-muted me-2"></i>
                                    <input type="text" class="border-0 w-75" placeholder="Search activities...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-2 flex-wrap">
                                    <span class="badge filter-badge active px-3 py-2">All</span>
                                    <span class="badge filter-badge px-3 py-2">User</span>
                                    <span class="badge filter-badge px-3 py-2">Security</span>
                                    <span class="badge filter-badge px-3 py-2">System</span>
                                    <span class="badge filter-badge px-3 py-2">Error</span>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Timeline -->
                        <div class="activity-timeline">
                            <!-- Activity Item -->
                            <template v-if="activities?.data?.length > 0">
                                <div v-for="activity in activities?.data" class="activity-item bg-white">
                                    <div class="d-flex gap-3">
                                        <div class="activity-icon "
                                             :class="{
                                                  'bg-success-soft text-success': activity.event === 'updated' || activity.event === 'created' || activity.event === 'login',
                                                  'bg-warning-soft text-warning': activity.event === 'logout',
                                                  'bg-danger-soft text-danger': activity.event === 'error',
                                                  'bg-info-soft text-info': !['updated', 'created', 'login', 'logout', 'error'].includes(activity.event)
                                             }"
                                        >
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">{{ activity.event }}</h6>
                                                <span class="activity-date">{{ activity.format_created_at }}</span>
                                            </div>
                                            <p class="text-muted mb-2">{{ activity.description}}</p>
                                            <div class="d-flex align-items-center">
                                                <div class="activity-user me-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                                    </svg>
                                                </div>
                                                <span class="text-muted small">IP: {{ activity?.properties?.ip }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <span class="text-muted small">Showing 1-4 of 256 activities</span>
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import {ref, onMounted} from 'vue'
import {useRoute} from "vue-router";

const route = useRoute();
const activities = ref();

function getImageUrl(post) {
    let image
    if (post.resized_image.length > 0) {
        image = post.resized_image
    } else {
        image = post.original_image
    }
    return new URL(image, import.meta.url).href
}

onMounted(() => {
    axios.get('/api/activity-logs')
        .then(({data}) => {
            activities.value = data;
        })
})
</script>
