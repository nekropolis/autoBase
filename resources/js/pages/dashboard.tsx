import AppLayout from '@/layouts/app-layout';
import {Head} from '@inertiajs/react';
import {type BreadcrumbItem, DashboardProps} from '@/types';
import ProblemList from '@/components/knowledge/ProblemList';
import InstructionList from '@/components/knowledge/InstructionList';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];


export default function Dashboard({problems, instructions, filters}: DashboardProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard"/>

            <div className="flex flex-col gap-4 p-4">
                {filters.search_type === 'problems' && <ProblemList problems={problems} />}
                {filters.search_type === 'instructions' && <InstructionList instructions={instructions} />}
                {filters.search_type === null && (
                    <>
                        <ProblemList problems={problems} />
                        <InstructionList instructions={instructions} />
                    </>
                )}
            </div>
        </AppLayout>
    );
}
