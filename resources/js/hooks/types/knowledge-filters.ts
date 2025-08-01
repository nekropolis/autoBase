import type { FormDataConvertible } from '@inertiajs/core';

export interface KnowledgeFilterFields {
    brand_id: string;
    model_id: string;
    modification_id: string;
    search_type: string;
    part: string;
    header: string;
}

export type KnowledgeFilterData = {
    [K in keyof KnowledgeFilterFields]: KnowledgeFilterFields[K];
} & {
    [key: string]: FormDataConvertible;
};
