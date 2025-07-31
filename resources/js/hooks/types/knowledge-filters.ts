import type { FormDataConvertible } from '@inertiajs/core';

export interface KnowledgeFilterFields {
    brand_id: string | number;
    model_id: string | number;
    modification_id: string | number;
    search_type: string;
    part: string;
}

export type KnowledgeFilterData = {
    [K in keyof KnowledgeFilterFields]: KnowledgeFilterFields[K];
} & {
    [key: string]: FormDataConvertible;
};
