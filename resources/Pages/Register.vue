<script setup>
import {DefaultLayout} from "../Layouts";
import {Heading} from "../Components";
import {InputText, FloatLabel, Button, DatePicker, Checkbox, Message, Toast, useToast} from "primevue";
import {ref} from "vue";
import {useAuthStore} from "../Stores";
import {Form} from '@primevue/forms'
import {zodResolver} from '@primevue/forms/resolvers/zod';
import {z} from "zod";
import dayjs from "dayjs";
import {useRouter} from "vue-router";
import {ROUTES} from "../router/routes.js";

const authStore = useAuthStore()
const data = ref({
    fio: '',
    birthday: '',
    passport: '',
    login: '',
    phone: '',
    email: '',
    password: '',
    password_repeat: '',
    rules: false
})
const router = useRouter();
const toast = useToast();

const resolver = ref(
    zodResolver(
        z.object({
            fio: z.string().regex(new RegExp('^[а-яёА-ЯЁ\\s\\-]+$'), {
                message: 'Допустимы только буквы русского алфавита, пробелы и тире.'
            }),
            birthday: z.date({
                message: 'Некорректная дата.'
            }),
            passport: z.string({
                message: 'Некорректная серия и номер паспорта.'
            }).min(10, {message: 'Некорректная серия и номер паспорта'}).max(10, {message: 'Некорректная серия и номер паспорта'}),
            login: z.string().regex(new RegExp('^[a-zA-Z\\s\\-]+$'), {
                message: 'Только буквы латинского алфавита, пробелы и тире.'
            }),
            phone: z.string().regex(new RegExp('^8 (\\d{3}) (\\d{3}-\\d{2}-\\d{2})$'), {
                message: 'Телефон должен быть вида 8 ххх ххх-хх-хх.',
            }),
            email: z.string().email({
                message: 'Некорректная почта.',
            }),
            password: z.string().min(6, {
                message: 'Минимальная длина пароля - 6 символов'
            }),
            password_repeat: z.string({
                required_error: 'Данное поле необходимо к заполнению.',
            }),
            rules: z.boolean().refine((val) => val === true, {
                message: 'Данное поле должно быть отмечено.'
            })
        }).refine((data) => data.password === data.password_repeat, {
            message: 'Пароли не совпадают',
            path: ['password_repeat']
        })
    )
)

const onSubmit = async ({valid, values}) => {
    if (!valid) {
        return;
    }

    try {
        const response = await authStore.register({
            ...values,
            birthday: dayjs(values.birthday).format('YYYY-MM-DD'),
            phone: +(values.phone.replace(new RegExp('[\\s-]', 'g'), '')),
        })

        if (response.data.success) {
            await router.push(ROUTES.LOGIN)
        }
    } catch (e) {
        toast.add({
            severity: 'error',
            summary: 'Ошибка!',
            detail: Object.values(e.response.data.errors).flat().map((err) => err + '\n').join(''),
            life: 3000,
            closable: true,
        })
    }


}


</script>

<template>
    <DefaultLayout>
        <Toast/>
        <div class="h-[calc(100vh-72px)]">
            <div class="container max-w-3xl mx-auto flex flex-col justify-center h-full">
                <Heading class="w-full" title="Регистрация"/>
                <Form v-slot="$form" :initial-values="data" :resolver="resolver" class="space-y-3 mt-6"
                      @submit="onSubmit">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <FloatLabel variant="in">
                                <InputText
                                    id="fio"
                                    v-model="data.fio"
                                    variant="filled"
                                    name="fio"
                                    fluid
                                />
                                <label for="fio">ФИО</label>
                            </FloatLabel>
                            <Message v-if="$form.fio?.invalid" severity="error" size="small" variant="simple">
                                {{ $form.fio.error.message }}
                            </Message>
                        </div>
                        <div class="flex flex-col">
                            <FloatLabel variant="in">
                                <DatePicker id="birthday" v-model="data.birthday" fluid name="birthday"/>
                                <label for="birthday">День рождения</label>
                            </FloatLabel>
                            <Message v-if="$form.birthday?.invalid" severity="error" size="small" variant="simple">
                                {{ $form.birthday.error.message }}
                            </Message>
                        </div>
                        <div class="flex flex-col">
                            <FloatLabel variant="in">
                                <InputText id="passport" v-model="data.passport" name="passport" variant="filled"
                                           fluid/>
                                <label for="passport">Паспорт</label>
                            </FloatLabel>
                            <Message v-if="$form.passport?.invalid" severity="error" size="small" variant="simple">
                                {{ $form.passport.error.message }}
                            </Message>
                        </div>
                        <div class="flex flex-col">
                            <FloatLabel variant="in">
                                <InputText id="login" v-model="data.login" name="login" variant="filled" fluid/>
                                <label for="login">Логин</label>
                            </FloatLabel>
                            <Message v-if="$form.login?.invalid" severity="error" size="small" variant="simple">
                                {{ $form.login.error.message }}
                            </Message>
                        </div>
                        <div class="flex flex-col">
                            <FloatLabel variant="in">
                                <InputText id="phone" v-model="data.phone" name="phone" variant="filled" type="tel"
                                           fluid/>
                                <label for="phone">Номер телефона</label>
                            </FloatLabel>
                            <Message v-if="$form.phone?.invalid" severity="error" size="small" variant="simple">
                                {{ $form.phone.error.message }}
                            </Message>
                        </div>
                        <div class="flex flex-col">
                            <FloatLabel variant="in">
                                <InputText id="email" v-model="data.email" name="email" variant="filled" type="email"
                                           fluid/>
                                <label for="email">Почта</label>
                            </FloatLabel>
                            <Message v-if="$form.email?.invalid" severity="error" size="small" variant="simple">
                                {{ $form.email.error.message }}
                            </Message>
                        </div>
                        <div class="flex flex-col">
                            <FloatLabel variant="in">
                                <InputText id="password" v-model="data.password" name="password" variant="filled"
                                           type="password" fluid/>
                                <label for="password">Пароль</label>
                            </FloatLabel>
                            <Message v-if="$form.password?.invalid" severity="error" size="small" variant="simple">
                                {{ $form.password.error.message }}
                            </Message>
                        </div>
                        <div class="flex flex-col">
                            <FloatLabel variant="in">
                                <InputText id="password_repeat" v-model="data.password_repeat" name="password_repeat"
                                           variant="filled" type="password" fluid/>
                                <label for="password_repeat">Подтвердите пароль</label>
                            </FloatLabel>
                            <Message v-if="$form.password_repeat?.invalid" severity="error" size="small"
                                     variant="simple">
                                {{ $form.password_repeat.error.message }}
                            </Message>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex items-center gap-2">
                                <Checkbox input-id="rules" binary name="rules" v-model="data.rules"/>
                                <label for="rules" class="text-zinc-600 font-medium text-sm my-2"
                                       :class="{ '!text-red-500': $form.rules?.invalid }">Я согласен с правилами
                                    регистрации</label>
                            </div>
                            <Message v-if="$form.rules?.invalid" severity="error" size="small" variant="simple">
                                {{ $form.rules.error.message }}
                            </Message>
                        </div>
                    </div>
                    <Button
                        class="w-full !mt-4 !border-0 !bg-[#f4c82c] font-medium"
                        type="submit"
                    >
                        Войти
                    </Button>
                </Form>
            </div>
        </div>
    </DefaultLayout>
</template>

<style>
.p-inputtext:enabled:focus {
    border-color: #265BE3 !important;
}

.p-floatlabel:has(input:focus) label, .p-floatlabel:has(input:-webkit-autofill) label, .p-floatlabel:has(textarea:focus) label, .p-floatlabel:has(.p-inputwrapper-focus) label {
    color: #265BE3 !important;
}

.p-inputtext.p-variant-filled {
    background-color: #fff !important;
}

.p-checkbox-checked .p-checkbox-box {
    border-color: #265BE3 !important;
    background: #265BE3 !important;
}
</style>
